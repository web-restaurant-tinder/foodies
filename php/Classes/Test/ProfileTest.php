<?php
namespace WebRestaurantTinder\Foodies\Test;

use WebRestaurantTinder\Foodies\Profile;

//TODO remember to add this to my Jumbotron class!!!!
//Hack!!! - added so this class could see DataDesignTest
//require_once(dirname(__DIR__) . "/Jumbotron/DataDesignTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

class ProfileTest extends DataDesignTest {

	private $VALID_ACTIVATION_TOKEN;	//this will be done in the setup.
	private $VALID_CLOUDINARY_ID = "somecloudid2542";
	private $VALID_AVATAR_URL = "https://avatar.org";
	private $VALID_PROFILE_EMAIL = "nortiz41@cnm.edu";
	private $VALID_PROFILE_HASH;	//this will be done in the setup.
	private $VALID_USERNAME = "nortiz41";
	private $VALID_FIRSTNAME = "nathan";
	private $VALID_LASTNAME = "ortiz";

	public function setUp() : void {
		parent::setUp();

		$password = "my_super_secret_password";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 8]);
		$this->VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}

	public function testInsertValidProfile() : void {
		//get count of author records in db before we run the Jumbotron.
		$numRows = $this->getConnection()->getRowCount("profile");

		//insert an author record in the db
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_FIRSTNAME, $this->VALID_PROFILE_HASH, $this->VALID_LASTNAME, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		//check count of author records in the db after the insert
		$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		//get a copy of the record just inserted and validate the values
		// make sure the values that went into the record are the same ones that come out
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId()->toString());
		self::assertEquals($profileId, $pdoProfile->getProfileId());
		self::assertEquals($this->VALID_ACTIVATION_TOKEN, $pdoProfile->getProfileActivationToken());
		self::assertEquals($this->VALID_CLOUDINARY_ID, $pdoProfile->getProfileAvatarCloudinaryId());
		self::assertEquals($this->VALID_AVATAR_URL, $pdoProfile->getProfileAvatarUrl());
		self::assertEquals($this->VALID_PROFILE_EMAIL, $pdoProfile->getProfileEmail());
		self::assertEquals($this->VALID_PROFILE_HASH, $pdoProfile->getProfileHash());
		self::assertEquals($this->VALID_USERNAME, $pdoProfile->getProfileUserName());
		self::assertEquals($this->VALID_FIRSTNAME, $pdoProfile->getProfileFirstName());
		self::assertEquals($this->VALID_LASTNAME, $pdoProfile->getProfileLastName());

	}

	public function testUpdateValidProfile() : void {
		//get count of author records in db before we run the Jumbotron.
		$numRows = $this->getConnection()->getRowCount("profile");

		//insert an author record in the db
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_FIRSTNAME, $this->VALID_PROFILE_HASH, $this->VALID_LASTNAME, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());
		$profile->update($this->getPDO());

		//check count of author records in the db after the insert
		$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		//get a copy of the record just inserted and validate the values
		// make sure the values that went into the record are the same ones that come out
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId()->toString());
		self::assertEquals($profileId, $pdoProfile->getProfileId());
		self::assertEquals($this->VALID_ACTIVATION_TOKEN, $pdoProfile->getProfileActivationToken());
		self::assertEquals($this->VALID_CLOUDINARY_ID, $pdoProfile->getProfileAvatarCloudinaryId());
		self::assertEquals($this->VALID_AVATAR_URL, $pdoProfile->getProfileAvatarUrl());
		self::assertEquals($this->VALID_PROFILE_EMAIL, $pdoProfile->getProfileEmail());
		self::assertEquals($this->VALID_PROFILE_HASH, $pdoProfile->getProfileHash());
		self::assertEquals($this->VALID_USERNAME, $pdoProfile->getProfileUserName());
		self::assertEquals($this->VALID_FIRSTNAME, $pdoProfile->getProfileFirstName());
		self::assertEquals($this->VALID_LASTNAME, $pdoProfile->getProfileLastName());
	}


	public function testDeleteValidProfile() : void {

		//get count of author records in db before we run the Jumbotron.
		$numRows = $this->getConnection()->getRowCount("profile");
		{

			$profileId=generateUuidV4()->toString();
			$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,
				$this->VALID_PROFILE_EMAIL, $this->VALID_FIRSTNAME, $this->VALID_PROFILE_HASH, $this->VALID_LASTNAME, $this->VALID_USERNAME);
			$profile->insert($this->getPDO());

		}
		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		//try to get the last record we inserted. it should not exist.
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(),$profile->getProfileId()->toString());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}



	public function testGetValidProfileByProfileId(): void {

//get count of profile records in db before we run the test
		$numRows = $this->getConnection()->getRowCount("profile");
		//get an profile record in the db by Id
		$profileId = generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_FIRSTNAME, $this->VALID_PROFILE_HASH, $this->VALID_LASTNAME, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());


		$profile->getProfileByProfileId($this->getPDO(),$profileId);
		//check count of profile record in the db after the insert
		$numRowsAfter = $this->getConnection()->getRowCount("profile");
		self::assertEquals($numRows + 1, $numRowsAfter,"checked record count");
	}



	/**
	 * test grabbing a Profile by email
	 **/
	public function testGetValidProfileByEmail() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_FIRSTNAME, $this->VALID_PROFILE_HASH, $this->VALID_LASTNAME, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAvatarCloudinaryId(), $this->VALID_CLOUDINARY_ID);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERNAME);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_FIRSTNAME);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_LASTNAME);
	}




	public function testProfileByUserName(): void{
//get count of Profile records in db before we run the test
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId=generateUuidV4()->toString();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_FIRSTNAME, $this->VALID_PROFILE_HASH, $this->VALID_LASTNAME, $this->VALID_USERNAME);

		$profile->insert($this->getPDO());

		//Returns an array
		$results = Profile::getProfileByProfileUserName($this->getPDO(),$profile->getProfileUserName());
		$numRowsAfterInsert = $this->getConnection()->getRowCount("profile");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		// grab the result from the array and validate it
		$pdoProfile = $results;
		$this->assertEquals($profileId, $pdoProfile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAvatarCloudinaryId(), $this->VALID_CLOUDINARY_ID);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_FIRSTNAME);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_LASTNAME);

	}

	public function testGetProfileByProfileFirstNameAndProfileLastName() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new profile and insert to into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_FIRSTNAME, $this->VALID_PROFILE_HASH, $this->VALID_LASTNAME, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileFirstNameAndProfileLastName($this->getPDO(), $profile->getProfileFirstName(), $profile->getProfileLastName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		// grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($profileId, $pdoProfile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAvatarCloudinaryId(), $this->VALID_CLOUDINARY_ID);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_FIRSTNAME);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_LASTNAME);
	}



	public function testGetValidProfileByActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,
			$this->VALID_PROFILE_EMAIL, $this->VALID_FIRSTNAME, $this->VALID_PROFILE_HASH, $this->VALID_LASTNAME, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($profileId, $pdoProfile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAvatarCloudinaryId(), $this->VALID_CLOUDINARY_ID);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_FIRSTNAME);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_LASTNAME);
	}

}