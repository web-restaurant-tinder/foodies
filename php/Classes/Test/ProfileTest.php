<?php
namespace WebRestaurantTinder\Foodies\Test;

use WebRestaurantTinder\Foodies\Profile;

//TODO remember to add this to my Test class!!!!
//Hack!!! - added so this class could see DataDesignTest
//require_once(dirname(__DIR__) . "/Test/DataDesignTest.php");

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
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 45]);
		$this->VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}

	public function testInsertValidProfile() : void {
		//get count of author records in db before we run the Test.
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
		//get count of author records in db before we run the Test.
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

		//get count of author records in db before we run the Test.
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

//	/**
//	 * test creating a Profile and then deleting it
//	 **/
//	public function testDeleteValidProfile() : void {
//		// count the number of rows and save it for later
//		$numRows = $this->getConnection()->getRowCount("profile");
//
//		$profileId = generateUuidV4();
//		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_CLOUDINARY_ID, $this->VALID_AVATAR_URL,
//			$this->VALID_PROFILE_EMAIL, $this->VALID_FIRSTNAME, $this->VALID_PROFILE_HASH, $this->VALID_LASTNAME, $this->VALID_USERNAME);
//		$profile->insert($this->getPDO());
//
//
//		// delete the Profile from mySQL
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
//		$profile->delete($this->getPDO());
//
//		// grab the data from mySQL and enforce the Profile does not exist
//		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
//		$this->assertNull($pdoProfile);
//		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
//	}
//

//
//	public function testGetValidProfileByProfileId($pdoProfile) : void {
//		//how many records were in the db before we start?
//		$numRows = $this->getConnection()->getRowCount("profile");
//
//		//now insert a row of data
//		$profileId = generateUuidV4()->toString();
//		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_AVATAR_URL, $this->VALID_AUTHOR_EMAIL, $this->VALID_AUTHOR_HASH, $this->VALID_USERNAME);
//		$profile->insert($this->getPDO());
//
//		//validate new row count in the table - should be old row count + 1 if insert is successful
//		$numRowsAfterInsert = $this->getConnection()->getRowCount("author");
//		self::assertEquals($numRows + 1, $numRowsAfterInsert);
//
//		//now get the row we just inserted and verify that the data coming out of the db matches the data we put in the db
//		$pdoAuthor = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId()->toString());
//		self::assertEquals($pdoProfile->getProfileId(), $profileId);
//		self::assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
//		self::assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_AVATAR_URL);
//		self::assertEquals($pdoProfile->getProfileEmail(), $this->VALID_AUTHOR_EMAIL);
//		self::assertEquals($pdoProfile->getProfileHash(), $this->VALID_AUTHOR_HASH);
//		self::assertEquals($pdoProfile->getProfileUsername(), $this->VALID_USERNAME);
//	}
//
//
//	public function testGetValidProfileByProfileEmail($pdoProfile) : void {
//		//how many records were in the db before we start?
//		$numRows = $this->getConnection()->getRowCount("profile");
//
//		//now insert a row of data
//		$profileId = generateUuidV4()->toString();
//		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_AVATAR_URL, $this->VALID_AUTHOR_EMAIL, $this->VALID_AUTHOR_HASH, $this->VALID_USERNAME);
//		$profile->insert($this->getPDO());
//
//		//validate new row count in the table - should be old row count + 1 if insert is successful
//		$numRowsAfterInsert = $this->getConnection()->getRowCount("author");
//		self::assertEquals($numRows + 1, $numRowsAfterInsert);
//
//		//now get the row we just inserted and verify that the data coming out of the db matches the data we put in the db
//		$pdoAuthor = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail()->toString());
//		self::assertEquals($pdoProfile->getProfileId(), $profileId);
//		self::assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
//		self::assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_AVATAR_URL);
//		self::assertEquals($pdoProfile->getProfileEmail(), $this->VALID_AUTHOR_EMAIL);
//		self::assertEquals($pdoProfile->getProfileHash(), $this->VALID_AUTHOR_HASH);
//		self::assertEquals($pdoProfile->getProfileUsername(), $this->VALID_USERNAME);
//	}
//
//	public function testGetValidProfileByProfileUserName($pdoProfile) : void {
//		//how many records were in the db before we start?
//		$numRows = $this->getConnection()->getRowCount("profile");
//
//		//now insert a row of data
//		$profileId = generateUuidV4()->toString();
//		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_AVATAR_URL, $this->VALID_AUTHOR_EMAIL, $this->VALID_AUTHOR_HASH, $this->VALID_USERNAME);
//		$profile->insert($this->getPDO());
//
//		//validate new row count in the table - should be old row count + 1 if insert is successful
//		$numRowsAfterInsert = $this->getConnection()->getRowCount("author");
//		self::assertEquals($numRows + 1, $numRowsAfterInsert);
//
//		//now get the row we just inserted and verify that the data coming out of the db matches the data we put in the db
//		$pdoAuthor = Profile::getProfileByProfileUserName($this->getPDO(), $profile->getProfileId()->toString());
//		self::assertEquals($pdoProfile->getProfileId(), $profileId);
//		self::assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
//		self::assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_AVATAR_URL);
//		self::assertEquals($pdoProfile->getProfileEmail(), $this->VALID_AUTHOR_EMAIL);
//		self::assertEquals($pdoProfile->getProfileHash(), $this->VALID_AUTHOR_HASH);
//		self::assertEquals($pdoProfile->getProfileUsername(), $this->VALID_USERNAME);
//	}
//
//
}