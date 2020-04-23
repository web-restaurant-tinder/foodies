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

	//add JONSERILIZABLE to constructor
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
	 * @param string $restaurantAddress
	 */
	public function setRestaurantAddress(string $restaurantAddress): void {
		$this->restaurantAddress = $restaurantAddress;
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
	public function setRestaurantAvatar(?string $newRestaurantAvatar): void {
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
	 * @param string $restaurantFoodType
	 */
	public function setRestaurantFoodType(string $restaurantFoodType): void {
		$this->restaurantFoodType = $restaurantFoodType;
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
	 * @param float $restaurantLat
	 */
	public function setRestaurantLat(float $restaurantLat): void {
		$this->restaurantLat = $restaurantLat;
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
	 * @param float $restaurantLng
	 */
	public function setRestaurantLng(float $restaurantLng): void {
		$this->restaurantLng = $restaurantLng;
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
	 * @param string $restaurantName
	 */
	public function setRestaurantName(string $restaurantName): void {
		$this->restaurantName = $restaurantName;
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
	 * @param string $restaurantPhone
	 */
	public function setRestaurantPhone(string $restaurantPhone): void {
		$this->restaurantPhone = $restaurantPhone;
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
	 * @param float $restaurantStarRating
	 */
	public function setRestaurantStarRating(float $restaurantStarRating): void {
		$this->restaurantStarRating = $restaurantStarRating;
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
	 * @param string $restaurantUrl
	 */
	public function setRestaurantUrl(string $restaurantUrl): void {
		$this->restaurantUrl = $restaurantUrl;
	}
}
