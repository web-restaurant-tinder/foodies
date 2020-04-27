<?php
namespace CNewsome2\Foodies;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");


use Ramsey\Uuid\Uuid;

/**
 * Restaurants Class
 * @package CNewsome2\Foodies
 */

class Restaurant {
	use ValidateUuid;
	use ValidateDate;


	/**
	 * id for this Restaurant; this is the Primary Key
	 * @var Uuid $restaurantId
	 */
	private $restaurantId;

	/**
	 * Address for this Restaurant
	 * @var string $restaurantAddress
	 */
	private $restaurantAddress;

	/**
	 * Avatar for this Restaurant
	 * @var string $restaurantAvatar
	 */
	private $restaurantAvatar;

	/**
	 * Food Type for this Restaurant
	 * @var string $restaurantFoodType
	 */
	private $restaurantFoodType;

	/**
	 * Latitude of this Restaurant
	 * @var float $restaurantLat
	 */
	private $restaurantLat;

	/**
	 * Longitude of this Restaurant
	 * @var float $restaurantLng
	 */
	private $restaurantLng;

	/**
	 * Name of this Restaurant
	 * @var string $restaurantName
	 */
	private $restaurantName;

	/**
	 * Phone number for this Restaurant
	 * @var string $restaurantPhone
	 */
	private $restaurantPhone;

	/**
	 * Star Rating for this Restaurant
	 * @var float $restaurantStarRating
	 */
	private $restaurantStarRating;

	/**
	 * Url for this Restaurant
	 * @var string $restaurantUrl
	 */
	private $restaurantUrl;

	/**
	 * Restaurants constructor.
	 * @param string|Uuid $newRestaurantId id of this Restaurant or null if a new Restaurant
	 * @param string $newRestaurantAddress
	 * @param string $newRestaurantAvatar
	 * @param string $newRestaurantFoodType
	 * @param float $newRestaurantLat
	 * @param float $newRestaurantLng
	 * @param string $newRestaurantName
	 * @param string $newRestaurantPhone
	 * @param float $newRestaurantStarRating
	 * @param string $newRestaurantUrl
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */


	public function __construct($newRestaurantId, string $newRestaurantAddress, string $newRestaurantAvatar, string $newRestaurantFoodType, float $newRestaurantLat, float $newRestaurantLng, string $newRestaurantName, string $newRestaurantPhone, float $newRestaurantStarRating, string $newRestaurantUrl) {
		try {
			$this->setRestaurantId($newRestaurantId);
			$this->setRestaurantAddress($newRestaurantAddress);
			$this->setRestaurantAvatar($newRestaurantAvatar);
			$this->setRestaurantFoodType($newRestaurantFoodType);
			$this->setRestaurantLat($newRestaurantLat);
			$this->setRestaurantLng($newRestaurantLng);
			$this->setRestaurantName($newRestaurantName);
			$this->setRestaurantPhone($newRestaurantPhone);
			$this->setRestaurantStarRating($newRestaurantStarRating);
			$this->setRestaurantUrl($newRestaurantUrl);


		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for restaurantId
	 *
	 * @return Uuid value of restaurantId
	 */
	public function getRestaurantId(): Uuid {
		return ($this->restaurantId);
	}

	/**
	 * mutator method for restaurantId
	 *
	 * @param Uuid|string $newRestaurantId new value of restaurantId
	 * @throws \RangeException if $newRestaurantId is out of range
	 * @throws \TypeError if $newRestaurantId is not a uuid or string
	 */
	public function setRestaurantId($newRestaurantId): void {
		try {
			$uuid = self::validateUuid($newRestaurantId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->restaurantId = $uuid;
	}

	/**
	 * accessor method for restaurantAddress
	 *
	 * @return string value of restaurantAddress
	 */
	public function getRestaurantAddress(): string {
		return $this->restaurantAddress;
	}

	/**
	 * mutator method for restaurantAddress
	 * @param string $newRestaurantAddress
	 */
	public function setRestaurantAddress(string $newRestaurantAddress): void {
		$newRestaurantAddress = trim($newRestaurantAddress);
		$newRestaurantAddress = filter_var($newRestaurantAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRestaurantAddress) === true) {
			throw(new \InvalidArgumentException("Address is empty or insecure"));
		}

		// verify the Todo Author will fit in the database
		if(strlen($newRestaurantAddress) > 25) {
			throw(new \RangeException("Address is too large"));
		}
		$this->restaurantAddress = $newRestaurantAddress;
	}

	/**
	 * accessor method for restaurantAvatar
	 *
	 * @return string
	 */
	public function getRestaurantAvatar(): string {
		return $this->restaurantAvatar;
	}

	/**
	 * mutator method for restaurantAvatar
	 *
	 * @param string $newRestaurantAvatar
	 */
	public function setRestaurantAvatar(string $newRestaurantAvatar): void {

		$this->restaurantAvatar = $newRestaurantAvatar;
	}

	/**
	 * accessor method for restaurantFoodType
	 *
	 * @return string
	 */
	public function getRestaurantFoodType(): string {
		return $this->restaurantFoodType;
	}

	/**
	 * mutator method for restaurantFoodType
	 * @param string $newRestaurantFoodType
	 */
	public function setRestaurantFoodType(string $newRestaurantFoodType): void {
		$this->restaurantFoodType = $newRestaurantFoodType;
	}

	/**
	 * accessor method for restaurantLat
	 *
	 * @return float
	 */
	public function getRestaurantLat(): float {
		return $this->restaurantLat;
	}

	/**
	 * mutator method for restaurantLat
	 *
	 * @param float $newRestaurantLat
	 */
	public function setRestaurantLat(float $newRestaurantLat): void {
		$this->restaurantLat = $newRestaurantLat;
	}

	/**
	 * accessor method for restaurantLng
	 *
	 * @return float
	 */
	public function getRestaurantLng(): float {
		return $this->restaurantLng;
	}

	/**
	 * mutator method for restaurantLng
	 *
	 * @param float $newRestaurantLng
	 */
	public function setRestaurantLng(float $newRestaurantLng): void {
		$this->restaurantLng = $newRestaurantLng;
	}

	/**
	 * accessor method for restaurantName
	 *
	 * @return string
	 */
	public function getRestaurantName(): string {
		return $this->restaurantName;
	}

	/**
	 * mutator method for restaurantName
	 *
	 * @param string $newRestaurantName
	 */
	public function setRestaurantName(string $newRestaurantName): void {
		$newRestaurantPhone = trim($newRestaurantName);
		$newRestaurantPhone = filter_var($newRestaurantName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRestaurantName) === true) {
			throw(new \InvalidArgumentException("Restaurant Name is empty or insecure"));
		}

		// verify the Todo Author will fit in the database
		if(strlen($newRestaurantPhone) > 25) {
			throw(new \RangeException("Restaurant Name is too large"));
		}
		$this->restaurantName = $newRestaurantName;
	}

	/**
	 * accessor method for restaurantPhone
	 *
	 * @return string
	 */
	public function getRestaurantPhone(): string {
		return $this->restaurantPhone;
	}

	/**
	 * mutator method for restaurantPhone
	 *
	 * @param string $newRestaurantPhone
	 */
	public function setRestaurantPhone(string $newRestaurantPhone): void {
		$newRestaurantPhone = trim($newRestaurantPhone);
		$newRestaurantPhone = filter_var($newRestaurantPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRestaurantPhone) === true) {
			throw(new \InvalidArgumentException("Restaurant Phone is empty or insecure"));
		}

		// verify the Todo Author will fit in the database
		if(strlen($newRestaurantPhone) > 14) {
			throw(new \RangeException("Restaurant Phone Number is too large"));
		}
		$this->restaurantPhone = $newRestaurantPhone;
	}

	/**
	 * accessor method for restaurantStarRating
	 *
	 * @return float
	 */
	public function getRestaurantStarRating(): float {
		return $this->restaurantStarRating;
	}

	/**
	 * mutator method for restaurantStarRating
	 *
	 * @param float $newRestaurantStarRating
	 */
	public function setRestaurantStarRating(float $newRestaurantStarRating): void {
		$this->restaurantStarRating = $newRestaurantStarRating;
	}

	/**
	 * accessor method for restaurantUrl
	 *
	 * @return string
	 */
	public function getRestaurantUrl(): string {
		return $this->restaurantUrl;
	}

	/**
	 * mutator method for restaurantUrl
	 *
	 * @param string $newRestaurantUrl
	 */
	public function setRestaurantUrl(string $newRestaurantUrl): void {

		$newRestaurantUrl = trim($newRestaurantUrl);
		$newRestaurantUrl = filter_var($newRestaurantUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		try {
			// verify the avatar URL will fit in the database
			if(strlen($newRestaurantUrl) > 255) {
				throw(new \RangeException("url too long, must be less than 250 characters"));
			}
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->restaurantUrl = $newRestaurantUrl;
	}

	/**
	 * inserts this author into SQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function insert(\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO restaurant"
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["authorId"=>$this->authorId->getBytes(), "authorActivationToken"=> $this->authorActivationToken, "authorAvatarUrl"=> $this->authorAvatarUrl, "authorEmail"=> $this->authorEmail, "authorHash"=> $this->authorHash, "authorUsername"=> $this->authorUsername];
		$statement->execute($parameters);
	}
}
