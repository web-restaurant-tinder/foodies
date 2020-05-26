<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";

use WebRestaurantTinder\Foodies\Swipe;

if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {

    $secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort28/foodies.ini");
    $pdo = $secrets->getPdoObject();

    //determine which HTTP method was used
    $method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];


    //sanitize the search parameters
    $swipeRestaurantId = $id = filter_input(INPUT_GET, "swipeRestaurantId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $swipeProfileId = $id = filter_input(INPUT_GET, "swipeProfileId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);


    if($method === "GET") {
        //set XSRF cookie
        setXsrfCookie();


        if ($swipeRestaurantId !== null && $swipeProfileId !== null) {
            $swipe = Swipe::getSwipeByCurrentLoggedInUser($pdo, $swipeProfileId, $swipeRestaurantId);


            if ($swipe !== null) {
                $reply->data = $swipe;
            }

        } else if (empty($swipeRestaurantId) === false) {
            $reply->data = Swipe::getSwipeBySwipeRestaurantId($pdo, $swipeRestaurantId)->toArray();

        } else if (empty($swipeProfileId) === false) {
            $reply->data = Swipe::getSwipeBySwipeProfileId($pdo, $swipeProfileId)->toArray();
        } else {
            throw new InvalidArgumentException("incorrect search parameters ", 404);
        }

    } else if ($method === "POST" || $method === "DELETE") {
        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);

        if (empty($requestObject->swipeRestaurantId) === true) {
            throw (new \InvalidArgumentException("No Swipe Restaurant linked to the Swipe", 405));
        }

        if (empty($requestObject->swipeProfileId) === true) {
            throw (new \InvalidArgumentException("No Profile linked to the Swipe", 405));
        }

        if ($method === "POST") {

            verifyXsrf();

            if (empty($_SESSION["profile"]) === true) {
                throw(new \InvalidArgumentException("you must be logged in to swipe", 403));
            }

//            validateJwtHeader();

            $swipe = new Swipe($_SESSION["profile"]->getProfileId()->toString(), $requestObject->swipeRestaurantId, null, $requestObject->swipeRight);
            $swipe->insert($pdo);
            $reply->message = "swipe successful";

        } else if ($method === "DELETE") {
            verifyXsrf();

            validateJwtHeader();

            $swipe = Swipe::getSwipeBySwipeProfileIdAndSwipeRestaurantId($pdo, $requestObject->swipeProfileId, $requestObject->swipeRestaurantId);
            if ($swipe === null) {
                throw (new RuntimeException("swipe does not exist"));
            }


            if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $swipe->getSwipeProfileId()->toString()) {
                throw (new \InvalidArgumentException("Your are not allowed to delete this swipe", 403));
            }

            $swipe->delete($pdo);

            $reply->message = "Successfully un-swiped";
        }

    } else {
        throw new \InvalidArgumentException("invalid http request", 400);
    }

} catch (\Exception | \TypeError $exception) {
    $reply->status = $exception->getCode();
    $reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if ($reply->data === null) {
    unset($reply->data);
}

echo json_encode($reply);