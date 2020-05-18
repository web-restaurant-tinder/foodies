<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";

use WebRestaurantTinder\Foodies\Follow;

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
    $followFollowedProfileId = $id = filter_input(INPUT_GET, "followProfileId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $followProfileId = $id = filter_input(INPUT_GET, "followFollowedProfileId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);


    if($method === "GET") {
        //set XSRF cookie
        setXsrfCookie();

        //gets  a specific follow associated based on its composite key
        if ($followFollowedProfileId !== null && $followProfileId !== null) {
            $follow = Follow::getFollowByFollowProfileIdAndFollowFollowedProfileId($pdo, $followFollowedProfileId, $followProfileId);


            if ($follow !== null) {
                $reply->data = $follow;
            }

        } else if (empty($followFollowedProfileId) === false) {
            $reply->data = Follow::getFollowByFollowFollowedProfileId($pdo, $followFollowedProfileId)->toArray();

        } else if (empty($followProfileId) === false) {
            $reply->data = Follow::getFollowByFollowProfileId($pdo, $followProfileId)->toArray();
        } else {
            throw new InvalidArgumentException("incorrect search parameters ", 404);
        }

    } else if ($method === "POST" || $method === "PUT") {
        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);

        if (empty($requestObject->followFollowedProfileId) === true) {
            throw (new \InvalidArgumentException("No Followed Profile linked to the Follow", 405));
        }

        if (empty($requestObject->followProfileId) === true) {
            throw (new \InvalidArgumentException("No Profile linked to the Follow", 405));
        }

        if (empty($requestObject->followDate) === true) {
            $requestObject->FollowDate = date("y-m-d H:i:s");
        }

        if ($method === "POST") {

            verifyXsrf();

            if (empty($_SESSION ["follow"]) === true) {
                throw(new \InvalidArgumentException("you must be logged in to follow profiles", 403));
            }

//            validateJwtHeader();

            $follow = new Follow($_SESSION["follow"]->getFollowFollowedProfileId(), $requestObject->followProfileId);
            $follow->insert($pdo);
            $reply->message = "follow successful";

        } else if ($method === "PUT") {
            verifyXsrf();

            validateJwtHeader();

            $follow = Follow::getFollowByFollowProfileIdAndFollowFollowedProfileId($pdo, $requestObject->followFollowedProfileId, $requestObject->followProfileId);
            if ($follow === null) {
                throw (new RuntimeException("follow does not exist"));
            }


            if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $follow->getfollowFollowedProfileId()->toString()) {
               throw (new \InvalidArgumentException("Your are not allowed to delete this follow", 403));
            }

            $follow->delete($pdo);

            $reply->message = "Successfully un-followed";
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