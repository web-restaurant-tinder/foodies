<?php
namespace WebRestaurantTinder\Foodies\Test;

use WebRestaurantTinder\Foodies\{Restaurant};

//TODO remember to add this to my Test class!!!!
//Hack!!! - added so this class could see DataDesignTest
//require_once(dirname(__DIR__) . "/Test/DataDesignTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

class RestaurantTest extends DataDesignTest {

	private $VALID_ADDRESS = "123 Main St.";
	private $VALID_AVATAR;	//this will be done in the setup.
	private $VALID_FOOD_TYPE = "Italian";
	private $VALID_LAT = "35.105685";
	private $VALID_LNG = "-106.665658";
	private $VALID_NAME = "nameOfRestaurant";
	private $VALID_PHONE = "555-555-5555";
	private $VALID_STAR_RATING = "five stars";
	private $VALID_URL = "https://nameOfRestaurant.com";


	public function setUp() : void {
		parent::setUp();

	}

	public function testInsertValidRestaurant() : void {
		//get count of restaurant records in db before we run the test.
		$numRows = $this->getConnection()->getRowCount("restaurant");

		//insert an restaurant record in the db
		$restaurantId = generateUuidV4()->toString();
		$restaurant = new Restaurant($restaurantId,$this->VALID_ADDRESS ,$this->VALID_AVATAR ,$this->VALID_FOOD_TYPE, $this->VALID_LAT, $this->VALID_LNG, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STAR_RATING, $this->VALID_URL);
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
		self::assertEquals($this->VALID_LAT, $pdoRestaurant->getRestaurantLat());
		self::assertEquals($this->VALID_LNG, $pdoRestaurant->getRestaurantLng());
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
		self::assertEquals($this->VALID_LAT, $pdoRestaurant->getRestaurantLat());
		self::assertEquals($this->VALID_LNG, $pdoRestaurant->getRestaurantLng());
		self::assertEquals($this->VALID_NAME, $pdoRestaurant->getRestaurantName());
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
				$this->VALID_NAME,
				$this->VALID_PHONE,
				$this->VALID_STAR_RATING,
				$this->VALID_URL);
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
		self::assertEquals($pdoRestaurant->getRestaurantId(), $restaurantId);
		self::assertEquals($pdoRestaurant->getRestaurantAddress(), $this->VALID_ADDRESS);
		self::assertEquals($pdoRestaurant->getRestaurantAvatar(), $this->VALID_AVATAR);
		self::assertEquals($pdoRestaurant->getRestaurantFoodType(), $this->VALID_FOOD_TYPE);
		self::assertEquals($pdoRestaurant->getRestaurantLat(), $this->VALID_LAT);
		self::assertEquals($pdoRestaurant->getRestaurantLng(), $this->VALID_LNG);
		self::assertEquals($pdoRestaurant->getRestaurantName(), $this->VALID_NAME);
		self::assertEquals($pdoRestaurant->getRestaurantPhone(), $this->VALID_PHONE);
		self::assertEquals($pdoRestaurant->getRestaurantStarRating(), $this->VALID_STAR_RATING);
		self::assertEquals($pdoRestaurant->getRestaurantUrl(), $this->VALID_URL);
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
		$pdoRestaurant = Restaurant::getRestaurantByRestaurantFoodType($this->getPDO(), $restaurant->getRestaurantFoodType()->toString());
		self::assertEquals($pdoRestaurant->getRestaurantId(), $restaurantId);
		self::assertEquals($pdoRestaurant->getRestaurantAddress(), $this->VALID_ADDRESS);
		self::assertEquals($pdoRestaurant->getRestaurantAvatar(), $this->VALID_AVATAR);
		self::assertEquals($pdoRestaurant->getRestaurantFoodType(), $this->VALID_FOOD_TYPE);
		self::assertEquals($pdoRestaurant->getRestaurantLat(), $this->VALID_LAT);
		self::assertEquals($pdoRestaurant->getRestaurantLng(), $this->VALID_LNG);
		self::assertEquals($pdoRestaurant->getRestaurantName(), $this->VALID_NAME);
		self::assertEquals($pdoRestaurant->getRestaurantPhone(), $this->VALID_PHONE);
		self::assertEquals($pdoRestaurant->getRestaurantStarRating(), $this->VALID_STAR_RATING);
		self::assertEquals($pdoRestaurant->getRestaurantUrl(), $this->VALID_URL);
	}

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
		$pdoRestaurant = Restaurant::getRestaurantByRestaurantName($this->getPDO(), $restaurant->getRestaurantName()->toString());
		self::assertEquals($pdoRestaurant->getRestaurantId(), $restaurantId);
		self::assertEquals($pdoRestaurant->getRestaurantAddress(), $this->VALID_ADDRESS);
		self::assertEquals($pdoRestaurant->getRestaurantAvatar(), $this->VALID_AVATAR);
		self::assertEquals($pdoRestaurant->getRestaurantFoodType(), $this->VALID_FOOD_TYPE);
		self::assertEquals($pdoRestaurant->getRestaurantLat(), $this->VALID_LAT);
		self::assertEquals($pdoRestaurant->getRestaurantLng(), $this->VALID_LNG);
		self::assertEquals($pdoRestaurant->getRestaurantName(), $this->VALID_NAME);
		self::assertEquals($pdoRestaurant->getRestaurantPhone(), $this->VALID_PHONE);
		self::assertEquals($pdoRestaurant->getRestaurantStarRating(), $this->VALID_STAR_RATING);
		self::assertEquals($pdoRestaurant->getRestaurantUrl(), $this->VALID_URL);
	}

	public function testGetValidRestaurantByRestaurantDistance() : void {
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
		$pdoRestaurant = Restaurant::getRestaurantByRestaurantName($this->getPDO(), $restaurant->getRestaurantLat()->toFloat()); $restaurant->getRestaurantLng()->toFloat();
		self::assertEquals($pdoRestaurant->getRestaurantId(), $restaurantId);
		self::assertEquals($pdoRestaurant->getRestaurantAddress(), $this->VALID_ADDRESS);
		self::assertEquals($pdoRestaurant->getRestaurantAvatar(), $this->VALID_AVATAR);
		self::assertEquals($pdoRestaurant->getRestaurantFoodType(), $this->VALID_FOOD_TYPE);
		self::assertEquals($pdoRestaurant->getRestaurantLat(), $this->VALID_LAT);
		self::assertEquals($pdoRestaurant->getRestaurantLng(), $this->VALID_LNG);
		self::assertEquals($pdoRestaurant->getRestaurantName(), $this->VALID_NAME);
		self::assertEquals($pdoRestaurant->getRestaurantPhone(), $this->VALID_PHONE);
		self::assertEquals($pdoRestaurant->getRestaurantStarRating(), $this->VALID_STAR_RATING);
		self::assertEquals($pdoRestaurant->getRestaurantUrl(), $this->VALID_URL);
	}

	public function testGetValidRestaurant() : void {
		//how many records were in the db before we start?
		$numRows = $this->getConnection()->getRowCount("restaurant");
		$rowsInserted = 5;

		//now insert 5 rows of data
		for ($i=0; $i<$rowsInserted; $i++){
			$restaurantId = generateUuidV4()->toString();
			$restaurant = new Restaurant($restaurantId,
				$this->VALID_ADDRESS,
				$this->VALID_AVATAR,
				$this->VALID_FOOD_TYPE,
				$this->VALID_LAT,
				$this->VALID_LNG,
				$this->VALID_NAME,
				$this->VALID_PHONE,
				$this->VALID_STAR_RATING,
				$this->VALID_URL);;
			$restaurant->insert($this->getPDO());
		}

		//validate new row count in the table - should be old row count + 1 if insert is successful
		self::assertEquals($numRows + $rowsInserted, $this->getConnection()->getRowCount("restaurant"));

		//validate number of rows coming back from our function.
		self::assertEquals($numRows + $rowsInserted, $restaurant->getAllRestaurants($this->getPDO())->count());
	}
}