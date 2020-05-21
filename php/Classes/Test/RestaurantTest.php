<?php
namespace WebRestaurantTinder\Foodies\Test;


//TODO remember to add this to my Jumbotron class!!!!
//Hack!!! - added so this class could see DataDesignTest
//require_once(dirname(__DIR__) . "/Jumbotron/DataDesignTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

use WebRestaurantTinder\Foodies\Restaurant;

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
use Faker;

class RestaurantTest extends DataDesignTest {


	private $VALID_ADDRESS = "123 Main St.";
	private $VALID_AVATAR = "https://avatar.org";
	private $VALID_FOOD_TYPE = "Italian";
	private $VALID_LAT = 35.105682;
	private $VALID_LNG = -106.665653;
	private $VALID_NAME = "nameOfRestaurant";
	private $VALID_NAME_ARRAY = ["place2Eat", "eatingSpot"];
	private $VALID_PHONE = " ";
	private $VALID_PHONE_ARRAY = ["555-555-5555","123-123-1234"];
	private $VALID_STAR_RATING = "5";
	private $VALID_URL = "https://nameOfRestaurant.com";
	private $VALID_URL_ARRAY = ["https://place2Eat.com", "https://eatingSpot.com"];


	public function setUp() : void {
		parent::setUp();
		$faker = Faker\Factory::create();
		$this->VALID_PHONE = $faker->e164PhoneNumber;

	}

	public function testInsertValidRestaurant() : void {
		//get count of restaurant records in db before we run the test.
		$numRows = $this->getConnection()->getRowCount("restaurant");

		//insert an restaurant record in the db
		$restaurantId = generateUuidV4()->toString();
		$restaurant = new Restaurant($restaurantId,$this->VALID_ADDRESS ,$this->VALID_AVATAR ,$this->VALID_FOOD_TYPE, $this->VALID_LAT,
			$this->VALID_LNG, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STAR_RATING, $this->VALID_URL);

		$restaurant->insert($this->getPDO());

		//check count of restaurant records in the db after the insert
		$numRowsAfterInsert = $this->getConnection()->getRowCount("restaurant");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		//get a copy of the record just inserted and validate the values
		// make sure the values that went into the record are the same ones that come out
		$pdoRestaurant = Restaurant::getRestaurantByRestaurantId($this->getPDO(), $restaurant->getRestaurantId()->toString());
		self::assertEquals($restaurantId, $pdoRestaurant->getRestaurantId());
		self::assertEquals($this->VALID_ADDRESS, $pdoRestaurant->getRestaurantAddress());
		self::assertEquals($this->VALID_AVATAR, $pdoRestaurant->getRestaurantAvatar());
		self::assertEquals($this->VALID_FOOD_TYPE, $pdoRestaurant->getRestaurantFoodType());
		//todo Need to fix Lat and Lng.
		self::assertEquals(round($this->VALID_LAT * 1000) / 1000, round( $pdoRestaurant->getRestaurantLat()* 1000) / 1000);
		self::assertEquals(round($this->VALID_LNG * 1000) / 1000, round( $pdoRestaurant->getRestaurantLng()* 1000) / 1000);
		self::assertEquals($this->VALID_NAME, $pdoRestaurant->getRestaurantName());
		self::assertEquals($this->VALID_PHONE, $pdoRestaurant->getRestaurantPhone());
		self::assertEquals($this->VALID_STAR_RATING, $pdoRestaurant->getRestaurantStarRating());
		self::assertEquals($this->VALID_URL, $pdoRestaurant->getRestaurantUrl());

	}

	public function testUpdateValidRestaurant() : void {
		//get count of restaurant records in db before we run the test.
		$numRows = $this->getConnection()->getRowCount("restaurant");

		//insert an restaurant record in the db
		$restaurantId = generateUuidV4()->toString();
		$restaurant = new Restaurant($restaurantId,$this->VALID_ADDRESS ,$this->VALID_AVATAR, $this->VALID_FOOD_TYPE, $this->VALID_LAT, $this->VALID_LNG, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STAR_RATING, $this->VALID_URL);
		$restaurant->insert($this->getPDO());

		//update a value on the record I just inserted.
		$changedRestaurantName = $this->VALID_NAME . "changed";
		$restaurant->setRestaurantName($changedRestaurantName);
		$restaurant->update($this->getPDO());

		//check count of restaurant records in the db after the insert
		$numRowsAfterInsert = $this->getConnection()->getRowCount("restaurant");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		//get a copy of the record just inserted and validate the values
		// make sure the values that went into the record are the same ones that come out
		$pdoRestaurant = Restaurant::getRestaurantByRestaurantId($this->getPDO(), $restaurant->getRestaurantId()->toString());
		self::assertEquals($restaurantId, $pdoRestaurant->getRestaurantId());
		self::assertEquals($this->VALID_ADDRESS, $pdoRestaurant->getRestaurantAddress());
		self::assertEquals($this->VALID_AVATAR, $pdoRestaurant->getRestaurantAvatar());
		self::assertEquals($this->VALID_FOOD_TYPE, $pdoRestaurant->getRestaurantFoodType());
		//todo Need to fix Lat and Lng.
		self::assertEquals(round($this->VALID_LAT * 1000) / 1000, round( $pdoRestaurant->getRestaurantLat()* 1000) / 1000);
		self::assertEquals(round($this->VALID_LNG * 1000) / 1000, round( $pdoRestaurant->getRestaurantLng()* 1000) / 1000);
		self::assertNotEquals($this->VALID_NAME, $pdoRestaurant->getRestaurantName());
		self::assertEquals($this->VALID_PHONE, $pdoRestaurant->getRestaurantPhone());
		self::assertEquals($this->VALID_STAR_RATING, $pdoRestaurant->getRestaurantStarRating());
		self::assertEquals($this->VALID_URL, $pdoRestaurant->getRestaurantUrl());
		//verify that the saved username is same as the updated username
		self::assertEquals($changedRestaurantName, $pdoRestaurant->getRestaurantName());
	}

	public function testDeleteValidRestaurant() : void {

		//get count of restaurant records in db before we run the test.
		$numRows = $this->getConnection()->getRowCount("restaurant");

		$rowsInserted = 2;
		//now insert multiple rows of data
		for ($i=0; $i<$rowsInserted; $i++){
			$restaurantId = generateUuidV4()->toString();
			$restaurant = new Restaurant($restaurantId,
				$this->VALID_ADDRESS,
				$this->VALID_AVATAR,
				$this->VALID_FOOD_TYPE,
				$this->VALID_LAT,
				$this->VALID_LNG,
				$this->VALID_NAME_ARRAY[$i],
				$this->VALID_PHONE_ARRAY[$i],
				$this->VALID_STAR_RATING,
				$this->VALID_URL_ARRAY[$i]);
			$restaurant->insert($this->getPDO());
		}

		$numRowsAfterInsert = $this->getConnection()->getRowCount("restaurant");
		self::assertEquals($numRows + $rowsInserted, $numRowsAfterInsert);

		//now delete the last record we inserted
		$restaurant->delete($this->getPDO());

		//try to get the last record we inserted. it should not exist.
		$pdoRestaurant = Restaurant::getRestaurantByRestaurantId($this->getPDO(), $restaurant->getRestaurantId()->toString());

		//validate that only one record was deleted.
		$numRowsAfterDelete = $this->getConnection()->getRowCount("restaurant");
		self::assertEquals($numRows + $rowsInserted - 1, $numRowsAfterDelete);

	}

	public function testGetValidRestaurantByRestaurantId() : void {
		//how many records were in the db before we start?
		$numRows = $this->getConnection()->getRowCount("restaurant");

		//now insert a row of data
		$restaurantId = generateUuidV4()->toString();
		$restaurant = new Restaurant($restaurantId,$this->VALID_ADDRESS ,$this->VALID_AVATAR, $this->VALID_FOOD_TYPE, $this->VALID_LAT, $this->VALID_LNG, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STAR_RATING, $this->VALID_URL);
		$restaurant->insert($this->getPDO());

		//validate new row count in the table - should be old row count + 1 if insert is successful
		$numRowsAfterInsert = $this->getConnection()->getRowCount("restaurant");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		//now get the row we just inserted and verify that the data coming out of the db matches the data we put in the db
		$pdoRestaurant = Restaurant::getRestaurantByRestaurantId($this->getPDO(), $restaurant->getRestaurantId()->toString());

		self::assertEquals($restaurantId, $pdoRestaurant->getRestaurantId());
		self::assertEquals($this->VALID_ADDRESS, $pdoRestaurant->getRestaurantAddress());
		self::assertEquals($this->VALID_AVATAR, $pdoRestaurant->getRestaurantAvatar());
		self::assertEquals($this->VALID_FOOD_TYPE, $pdoRestaurant->getRestaurantFoodType());
		//TODO Need to fix Lats and Longs.
		self::assertEquals(round($this->VALID_LAT * 1000) / 1000, round( $pdoRestaurant->getRestaurantLat()* 1000) / 1000);
		self::assertEquals(round($this->VALID_LNG * 1000) / 1000, round( $pdoRestaurant->getRestaurantLng()* 1000) / 1000);
		self::assertEquals($this->VALID_NAME ,$pdoRestaurant->getRestaurantName());
		self::assertEquals($this->VALID_PHONE, $pdoRestaurant->getRestaurantPhone());
		self::assertEquals($this->VALID_STAR_RATING, $pdoRestaurant->getRestaurantStarRating());
		self::assertEquals($this->VALID_URL, $pdoRestaurant->getRestaurantUrl());
	}

	public function testGetValidRestaurantByRestaurantFoodType() : void {
		//how many records were in the db before we start?
		$numRows = $this->getConnection()->getRowCount("restaurant");

		//now insert a row of data
		$restaurantId = generateUuidV4()->toString();
		$restaurant = new Restaurant($restaurantId,$this->VALID_ADDRESS ,$this->VALID_AVATAR, $this->VALID_FOOD_TYPE, $this->VALID_LAT, $this->VALID_LNG, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STAR_RATING, $this->VALID_URL);
		$restaurant->insert($this->getPDO());

		//validate new row count in the table - should be old row count + 1 if insert is successful
		$numRowsAfterInsert = $this->getConnection()->getRowCount("restaurant");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		//now get the row we just inserted and verify that the data coming out of the db matches the data we put in the db
		$pdoRestaurant = Restaurant::getRestaurantByRestaurantFoodType($this->getPDO(), $restaurant->getRestaurantFoodType());
		self::assertEquals($restaurantId, $pdoRestaurant[0]->getRestaurantId());
		self::assertEquals($this->VALID_ADDRESS, $pdoRestaurant[0]->getRestaurantAddress());
		self::assertEquals($this->VALID_AVATAR, $pdoRestaurant[0]->getRestaurantAvatar());
		self::assertEquals($this->VALID_FOOD_TYPE, $pdoRestaurant[0]->getRestaurantFoodType());
		//TODO fix Lats and Longs
		self::assertEquals(round($this->VALID_LAT * 1000) / 1000, round( $pdoRestaurant[0]->getRestaurantLat()* 1000) / 1000);
		self::assertEquals(round($this->VALID_LNG * 1000) / 1000, round( $pdoRestaurant[0]->getRestaurantLng()* 1000) / 1000);
		self::assertEquals($this->VALID_NAME ,$pdoRestaurant[0]->getRestaurantName());
		self::assertEquals($this->VALID_PHONE, $pdoRestaurant[0]->getRestaurantPhone());
		self::assertEquals($this->VALID_STAR_RATING, $pdoRestaurant[0]->getRestaurantStarRating());
		self::assertEquals($this->VALID_URL, $pdoRestaurant[0]->getRestaurantUrl());
	}
//
	public function testGetValidRestaurantByRestaurantName() : void {
		//how many records were in the db before we start?
		$numRows = $this->getConnection()->getRowCount("restaurant");

		//now insert a row of data
		$restaurantId = generateUuidV4()->toString();
		$restaurant = new Restaurant($restaurantId,$this->VALID_ADDRESS ,$this->VALID_AVATAR, $this->VALID_FOOD_TYPE, $this->VALID_LAT, $this->VALID_LNG, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STAR_RATING, $this->VALID_URL);
		$restaurant->insert($this->getPDO());

		//validate new row count in the table - should be old row count + 1 if insert is successful
		$numRowsAfterInsert = $this->getConnection()->getRowCount("restaurant");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		//now get the row we just inserted and verify that the data coming out of the db matches the data we put in the db
		$pdoRestaurant = Restaurant::getRestaurantByRestaurantName($this->getPDO(), $restaurant->getRestaurantName());
		self::assertEquals($restaurantId, $pdoRestaurant[0]->getRestaurantId());
		self::assertEquals($this->VALID_ADDRESS, $pdoRestaurant[0]->getRestaurantAddress());
		self::assertEquals($this->VALID_AVATAR, $pdoRestaurant[0]->getRestaurantAvatar());
		self::assertEquals($this->VALID_FOOD_TYPE, $pdoRestaurant[0]->getRestaurantFoodType());
		//TODO fix Lats and Longs
		self::assertEquals(round($this->VALID_LAT * 1000) / 1000, round( $pdoRestaurant[0]->getRestaurantLat()* 1000) / 1000);
		self::assertEquals(round($this->VALID_LNG * 1000) / 1000, round( $pdoRestaurant[0]->getRestaurantLng()* 1000) / 1000);
		self::assertEquals($this->VALID_NAME ,$pdoRestaurant[0]->getRestaurantName());
		self::assertEquals($this->VALID_PHONE, $pdoRestaurant[0]->getRestaurantPhone());
		self::assertEquals($this->VALID_STAR_RATING, $pdoRestaurant[0]->getRestaurantStarRating());
		self::assertEquals($this->VALID_URL, $pdoRestaurant[0]->getRestaurantUrl());
	}
//
	public function testGetValidRestaurantByDistance() : void {
		//how many records were in the db before we start?
		$numRows = $this->getConnection()->getRowCount("restaurant");

		//now insert a row of data
		$restaurantId = generateUuidV4()->toString();
		$restaurant = new Restaurant($restaurantId,$this->VALID_ADDRESS ,$this->VALID_AVATAR, $this->VALID_FOOD_TYPE, $this->VALID_LAT, $this->VALID_LNG, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STAR_RATING, $this->VALID_URL);
		$restaurant->insert($this->getPDO());

		//validate new row count in the table - should be old row count + 1 if insert is successful
		$numRowsAfterInsert = $this->getConnection()->getRowCount("restaurant");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		//now get the row we just inserted and verify that the data coming out of the db matches the data we put in the db
		$pdoRestaurant = Restaurant::getRestaurantByDistance($this->getPDO(), $restaurant->getRestaurantLat(), $restaurant->getRestaurantLng(), 1);
		self::assertEquals($restaurantId, $pdoRestaurant[0]->getRestaurantId());
		self::assertEquals($this->VALID_ADDRESS, $pdoRestaurant[0]->getRestaurantAddress());
		self::assertEquals($this->VALID_AVATAR, $pdoRestaurant[0]->getRestaurantAvatar());
		self::assertEquals($this->VALID_FOOD_TYPE, $pdoRestaurant[0]->getRestaurantFoodType());
		//TODO fix Lats and Longs
		self::assertEquals(round($this->VALID_LAT * 1000) / 1000, round( $pdoRestaurant[0]->getRestaurantLat()* 1000) / 1000);
		self::assertEquals(round($this->VALID_LNG * 1000) / 1000, round( $pdoRestaurant[0]->getRestaurantLng()* 1000) / 1000);
		self::assertEquals($this->VALID_NAME ,$pdoRestaurant[0]->getRestaurantName());
		self::assertEquals($this->VALID_PHONE, $pdoRestaurant[0]->getRestaurantPhone());
		self::assertEquals($this->VALID_STAR_RATING, $pdoRestaurant[0]->getRestaurantStarRating());
		self::assertEquals($this->VALID_URL, $pdoRestaurant[0]->getRestaurantUrl());
	}

}