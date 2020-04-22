<?php

namespace Nortizcode\foodies;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use NortizCode\ObjectOriented\ValidateDate;
use NortizCode\ObjectOriented\ValidateDate;
use NortizCode\ObjectOriented\ValidateUuid;
use NortizCode\ObjectOriented\ValidateUuid;
use Ramsey\Uuid\Uuid;


/*
	/**
	 * This is the Profile class
	 * @author Nathan Ortiz <nortiz41@cnm.edu
 */

class Profile {
	use ValidateUuid;

	private $profileActivationToken;

	private $profileAvatar;

	private $profileEmail;

	private $profileFirstName;

	private $profileHash;

	private $profileId;

	private $profileLastName;

	private $profileUserName;

	//constructor method

	public function __construct($newProfileActivationToken, $newProfileAvatar, $newProfileEmail, $newProfileFirstName, $newProfileHash, $newProfileId, $newProfileLastName, $newProfileUsername) {
		try {
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAvatar($newProfileAvatar);
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

	//accessor method for author id

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

	//accessor method

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

	//accessor method

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


	public function getProfileAvatar(): string {
		return ($this->profileAvatar);
	}

	/**
	 * mutator method for at handle
	 *
	 * @param string $newAuthorAvatarUrl new value of profile avatar URL
	 * @throws \InvalidArgumentException if $newProfileAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newProfileAvatarUrl is > 255 characters
	 * @throws \TypeError if $newAtHandle is not a string
	 **/
	public function setProfileAvatar(string $newProfileAvatar): void {

		$newProfileAvatar = trim($newProfileAvatar);
		$newProfileAvatar = filter_var($newProfileAvatar, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the avatar URL will fit in the database
		if(strlen($newProfileAvatar) > 255) {
			throw(new \RangeException("image cloudinary content too large"));
		}
		// store the image cloudinary content
		$this->profileAvatar = $newProfileAvatar;
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