<?php

namespace WebRestaurantTinder\Foodies;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use WebRestaurantTinder\Foodies\ValidateDate;
use WebRestaurantTinder\Foodies\ValidateUuid;
use Ramsey\Uuid\Uuid;


/*
	/**
	 * This is the Profile class
	 * @author Nathan Ortiz <nortiz41@cnm.edu
 */

class Profile implements \JsonSerializable{
	use ValidateUuid;

	private $profileActivationToken;

	private $profileAvatarCloudinaryId;

	private $profileAvatarUrl;

	private $profileEmail;

	private $profileFirstName;

	private $profileHash;

	private $profileId;

	private $profileLastName;

	private $profileUserName;

	//constructor method

	public function __construct($newProfileActivationToken, $newProfileAvatarCloudinaryId, $newProfileAvatarUrl, $newProfileEmail, $newProfileFirstName, $newProfileHash, $newProfileId, $newProfileLastName, $newProfileUsername) {
		try {
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setprofileAvatarCloudinaryId($newProfileAvatarCloudinaryId);
			$this->setProfileAvatarUrl($newProfileAvatarUrl);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileFirstName($newProfileFirstName);
			$this->setProfileHash($newProfileHash);
			$this->setProfileId($newProfileId);
			$this->setProfileLastName($newProfileLastName);
			$this->setProfileUsername($newProfileUsername);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	//accessor method for ProfileActivationToken

	public function getProfileActivationToken($newProfileActivationToken) {
		return ($this->profileActivationToken);
	}

	//mutator method

	public function setProfileActivationToken($newProfileActivationToken): void {
		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}


		$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new\RangeException("profile activation is not valid"));
		}

		//make sure user activation token is only 32 characters
		if(strlen($newProfileActivationToken) !== 32) {
			throw(new\RangeException("profile activation token has to be 32"));
		}
		$this->profileActivationToken = $newProfileActivationToken;

	}





	public function getProfileAvatarCloudinaryId(): string {
		return ($this->profileAvatarCloudinaryId);
	}

	/**
	 * mutator method for image cloudinary token
	 *
	 * @param string $newProfileAvatarCloudinaryId new value of image cloudinary token
	 * @throws \InvalidArgumentException if $newProfileAvatarCloudinaryId is not a string or insecure
	 * @throws \TypeError if $newProfileAvatarCloudinaryId is not a string
	 **/
	public function setProfileAvatarCloudinaryId(string $newProfileAvatarCloudinaryId): void {
		// verify the image cloudinary token content is secure
		$newProfileAvatarCloudinaryId = filter_var($newProfileAvatarCloudinaryId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAvatarCloudinaryId) === true) {
			throw(new \InvalidArgumentException("image cloudinary id is empty or insecure"));
		}

		// store the image cloudinary token
		$this->profileAvatarCloudinaryId = $newProfileAvatarCloudinaryId;
	}





	public function getProfileAvatarUrl(): string {
		return ($this->profileAvatarUrl);
	}

	/**
	 * mutator method for at handle
	 *
	 * @param string $newProfileAvatarUrl new value of profile avatar URL
	 * @throws \InvalidArgumentException if $newProfileAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newProfileAvatarUrl is > 255 characters
	 * @throws \TypeError if $newAtHandle is not a string
	 **/
	public function setProfileAvatarUrl(string $newProfileAvatarUrl): void {

		$newProfileAvatarUrl = trim($newProfileAvatarUrl);
		$newProfileAvatarUrl = filter_var($newProfileAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the avatar URL will fit in the database
		if(strlen($newProfileAvatarUrl) > 255) {
			throw(new \RangeException("image content too large"));
		}
		// store the image content
		$this->profileAvatarUrl = $newProfileAvatarUrl;
	}


	//accessor method for ProfileEmail

	public function getProfileEmail(): string {
		return $this->profileEmail;
	}

	/**
	 * mutator method for email
	 **/
	public function setProfileEmail(string $newProfileEmail): void {

		// verify the email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}

		// verify the email will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile email is too large"));
		}

		// store the email
		$this->profileEmail = $newProfileEmail;
	}

	//accessor method for profileFirstName

	public function getProfileFirstName(): string {
		return ($this->profileFirstName);
	}

	/**
	 * mutator method for at profileFirstName
	 *
	 * @param string $newProfileFirstName new value of profileFirstName
	 * @throws \InvalidArgumentException if $newProfileFirstName is not a string or insecure
	 * @throws \RangeException if the name is over 32 characters
	 * @throws \TypeError if $newProfileFirstName is not a string
	 **/
	public function setProfileFirstName(string $newProfileFirstName) : void {
		// verify the at name is secure
		$newProfileFirstName = trim($newProfileFirstName);
		$newProfileFirstName = filter_var($newProfileFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileFirstName) === true) {
			throw(new \InvalidArgumentException("First name is empty or insecure"));
		}

		// verify the at handle will fit in the database
		if(strlen($newProfileFirstName) > 32) {
			throw(new \RangeException("First name is too large"));
		}

		// store the at first name
		$this->profileFirstName = $newProfileFirstName;
	}



	public function getProfileHash(): string {
		return $this->profileHash;
	}

	/**
	 * mutator method for profile hash password
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setProfileHash(string $newProfileHash): void {
		//enforce that the hash is properly formatted
		$newAuthorHash = trim($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile password hash empty or insecure"));
		}

		//enforce the hash is really an Argon hash
		$profileHashInfo = password_get_info($newProfileHash);
		if($profileHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("profile hash is not a valid hash"));
		}

		//enforce that the hash is exactly 97 characters.


		//store the hash
		$this->profileHash = $newProfileHash;
	}

	//accessor method for profile id

	public function getProfileId(): Uuid {
		return ($this->profileId);
	}

	//mutator method for author id

	public function setProfileId(string $newProfileId): void {
		try {
			$uuid = self::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->profileId = $uuid;
	}


	//accessor method for profileLastName

	public function getProfileLastName(): string {
		return ($this->profileLastName);
	}

	/**
	 * mutator method for at profileLastName
	 *
	 * @param string $newProfileLastName new value of profileFirstName
	 * @throws \InvalidArgumentException if $newProfileFirstName is not a string or insecure
	 * @throws \RangeException if the name is over 32 characters
	 * @throws \TypeError if $newProfileFirstName is not a string
	 **/
	public function setProfileLastName(string $newProfileLastName) : void {
		// verify the at name is secure
		$newProfileLastName = trim($newProfileLastName);
		$newProfileLastName = filter_var($newProfileLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileLastName === true) {
			throw(new \InvalidArgumentException("Last name is empty or insecure"));
		}

		// verify the at handle will fit in the database
		if(strlen($newProfileLastName) > 32) {
			throw(new \RangeException("Last name is too large"));
		}

		// store the at first name
		$this->profileLastName = $newProfileLastName;
	}


	public function getProfileUsername(): string {
		return ($this->profileUserName);
	}

	public function setProfileUsername(string $newProfileUsername): void {
		// verify the at handle is secure
		$newProfileUsername = trim($newProfileUsername);
		$newProfileUsername = filter_var($newProfileUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileUsername) === true) {
			throw(new \InvalidArgumentException("profile at handle is empty or insecure"));
		}

		// verify the at handle will fit in the database
		if(strlen($newProfileUsername) > 32) {
			throw(new \RangeException("profile at handle is too large"));
		}

		// store the at handle
		$this->profileUsername = $newProfileUsername;
	}

	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileAvatarCloudinaryId, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername) VALUES(:profileId, :profileActivationToken, :profileAvatarCloudinaryId, :profileAvatarUrl, :profileEmail, :profileFirstName, :profileHash, :profileLastName, :profileUserName,)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileAvatarCloudinaryId" => $this->profileAvatarCloudinaryId, "profileAvatarUrl" => $this->profileAvatarUrl,  "profileEmail" => $this->profileEmail, "profileFirstName" => $this->profileFirstName, "profileHash" => $this->profileHash, "profileLastName" => $this->profileLastName, "profileUsername" => $this->profileUserName];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function update(\PDO $pdo): void {


		// create query template
		$query = "UPDATE profile SET profileActivationToken = :profileActivationToken, profileAvatarCloudinaryId = :profileAvatarCloudinaryId, profileAvatarUrl = :profileAvatarUrl, profileEmail = :profileEmail, profileFirstName = :profileFirstName, profileHash = :profileHash, profileLastName = :profileLastName, profileUserName = :profileUserName WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template

		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileAvatarCloudinaryId" => $this->profileAvatarCloudinaryId, "profileAvatarUrl" => $this->profileAvatarUrl, "profileEmail" => $this->profileEmail, "profileFirstName" => $this->profileFirstName, "profileHash" => $this->profileHash, "profileLastName" => $this->profileLastName, "profileUserName" => $this->profileUserName];
		$statement->execute($parameters);
	}

	/**
	 * gets the Profile by profile id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param  $profileId profile Id to search for (the data type should be mixed/not specified)
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, $profileId):?Profile {
		// sanitize the profile id before searching
		try {
			$profileId = self::validateUuid($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}


		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAvatarCloudinaryId, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);

		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {

				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAvatarCloudinaryId"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileFirstName"],$row["profileHash"], $row["profileLastName"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * gets the Profile by email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileEmail email to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail): ?Profile {
		// sanitize the email before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_VALIDATE_EMAIL);

		if(empty($profileEmail) === true) {
			throw(new \PDOException("not a valid email"));
		}

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAvatarCloudinaryId, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);

		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAvatarCloudinaryId"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileFirstName"],$row["profileHash"], $row["profileLastName"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * gets the Profile by UserName
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileAtHandle at handle to search for
	 * @return \SPLFixedArray of all profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileUserName(\PDO $pdo, string $profileUserName) : \SPLFixedArray {
		// sanitize the username before searching
		$profileUserName = trim($profileUserName);
		$profileUserName = filter_var($profileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileUserName) === true) {
			throw(new \PDOException("not a valid at UserName"));
		}

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAvatarCloudinaryId, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername FROM profile WHERE profileUsername LIKE :profileUsername";
		$statement = $pdo->prepare($query);

		// bind the profile at handle to the place holder in the template
		$parameters = ["profileUserName" => $profileUserName];
		$statement->execute($parameters);



		$profiles = new \SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);


		while (($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAvatarCloudinaryId"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileFirstName"],$row["profileHash"], $row["profileLastName"], $row["profileUserName"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

	/**
	 * get the profile by profile activation token
	 *
	 * @param string $profileActivationToken
	 * @param \PDO object $pdo
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public
	static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) : ?Profile {
		//make sure activation token is in the right format and that it is a string representation of a hexadecimal
		$profileActivationToken = trim($profileActivationToken);
		if(ctype_xdigit($profileActivationToken) === false) {
			throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
		}

		//create the query template
		$query = "SELECT profileId, profileActivationToken, profileAvatarCloudinaryId, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);

		// bind the profile activation token to the placeholder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);

		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAvatarCloudinaryId"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileFirstName"],$row["profileHash"], $row["profileLastName"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}


	/**
	 * gets the Profile by first and last name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileFirstName $profileLastName first name to search for
	 * @return \SPLFixedArray of all profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileFirstNameAndProfileLastName(\PDO $pdo, string $profileFirstName, string $profileLastName) : \SPLFixedArray {
		// sanitize the string before searching
		$profileFirstName = trim($profileFirstName);
		$profileFirstName = filter_var($profileFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileFirstName) === true) {
			throw(new \PDOException("name not valid"));
		}
		$profileLastName = trim($profileLastName);
		$profileLastName = filter_var($profileLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileLastName === true) {
			throw(new \PDOException("name not valid"));
		}

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAvatarCloudinaryId, profileAvatarUrl, profileEmail, profileFirstName, profileHash, profileLastName, profileUsername FROM profile WHERE profileFirstName LIKE :profileFirstName AND profileLastName LIKE :profileLastName";
		$statement = $pdo->prepare($query);

		// bind the profile First and Last name to the place holder in the template
		$parameters = ["profileFirstName" => $profileFirstName, "profileLastName" => $profileLastName];
		$statement->execute($parameters);



		$profiles = new \SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);


		while (($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAvatarCloudinaryId"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileFirstName"],$row["profileHash"], $row["profileLastName"], $row["profileUserName"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}



	/**
	 * @inheritDoc
	 */
	public function jsonSerialize(){
		$fields = get_object_vars($this);
		$fields["profileId"] = $this->profileId->toString();
		unset($fields["profileActivationToken"]);
		unset($fields["profileHash"]);
		return($fields);
	}
}