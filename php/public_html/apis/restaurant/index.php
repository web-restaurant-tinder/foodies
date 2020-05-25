<?php


require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__,3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";

use WebRestaurantTinder\Foodies\Restaurant;

/**
 * API for profile
 *
 * @author Gkephart
 * @version 1.0
 */

//verify the session, if it is not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
    //grab the mySQL connection

    $secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort28/foodies.ini");
    $pdo = $secrets->getPdoObject();


    //determine which HTTP method was used
    $method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

    // sanitize input
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $restaurantName = filter_input(INPUT_GET, "restaurantName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $restaurantFoodType = filter_input(INPUT_GET, "restaurantFoodType", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $restaurantLat = filter_input(INPUT_GET, "restaurantLat", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $restaurantLng = filter_input(INPUT_GET, "restaurantLng", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $distance = filter_input(INPUT_GET, "distance", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);


    if($method === "GET") {
        //set XSRF cookie
        setXsrfCookie();

        //gets a post by content
        if(empty($id) === false) {
            $reply->data = Restaurant::getRestaurantByRestaurantId($pdo, $id);
        } else if(empty($restaurantName) === false) {
            $reply->data = Restaurant::getRestaurantByRestaurantName($pdo, $restaurantName);
        } else if(empty($restaurantFoodType) === false) {
            $reply->data = Restaurant::getRestaurantByRestaurantFoodType($pdo, $restaurantFoodType);
        } else if (empty($restaurantLat)===false && empty($restaurantLng)===false) {
            $reply->data = Restaurant::getRestaurantByDistance($pdo, $restaurantLat, $restaurantLng, $distance);
        } else {
            throw new InvalidArgumentException("Incorrect search parameters", 404);
        }
    } else {
        throw (new InvalidArgumentException("Invalid HTTP request", 400));
    }
    // catch any exceptions that were thrown and update the status and message state variable fields
} catch
(\Exception | \TypeError $exception) {
    $reply->status = $exception->getCode();
    $reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
    unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);