<?php
require_once(dirname(__DIR__, 1) . "/Classes/Restaurant.php");
require_once("uuid.php");
require_once("yelpconfigs.php");

use WebRestaurantTinder\Foodies\Restaurant;

// The pdo object has been created for you.
require_once("/etc/apache2/capstone-mysql/Secrets.php");
$secrets =  new Secrets("/etc/apache2/capstone-mysql/cohort28/foodies.ini");
$pdo = $secrets->getPdoObject();

//cURL - https://www.php.net/manual/en/function.curl-setopt.php
//$yelpToken is in a separate configs.php file that is not committed to github.
$authorization = "Authorization: Bearer " . $yelpToken;

for ($offset = 0; $offset < 200; $offset = $offset + 20) {

    $ch = curl_init('https://api.yelp.com/v3/businesses/search?term=restaurants&location=NM&offset=' . $offset);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $businesses = json_decode($result)->businesses;

    foreach ($businesses as $business) {
        echo($business->id . "<br>");
        echo($business->name . "<br>");
        echo($business->url . "<br>");
        echo($business->location->display_address[0] . ", " . $business->location->display_address[1] . "<br>");
//        var_dump($business->location->display_address);
        echo($business->display_phone . "<br>");
        echo($business->image_url . "<br>");
        echo($business->categories[0]->title . "<br>");
        echo($business->rating . "<br>");
        echo($business->coordinates->latitude . "<br>");
        echo($business->coordinates->longitude . "<br>");
        echo "<br>";

        $bus = new Restaurant(generateUuidV4()->toString(), $business->location->display_address[0] . ", " . $business->location->display_address[1],
            $business->image_url, $business->categories[0]->title, $business->coordinates->latitude, $business->coordinates->longitude, $business->name
        , $business->display_phone, $business->rating, $business->url);
        $bus->insert($pdo);
    }
}