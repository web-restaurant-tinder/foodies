<?php
namespace CNewsome2\Foodies;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");


use Ramsey\Uuid\Uuid;

/**
 * Restaurants Class
 * @package CNewsome2\Foodies
 */

class Restaurants {
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
	 * @var integer $restaurantLat
	 */
	private $restaurantLat;

	/**
	 * Longitude of this Restaurant
	 * @var integer $restaurantLng
	 */
	private $restaurantLng;

	/**
	 * Name of this Restaurant
	 * @var string $restaurantName
	 */
	private $restaurantName;

	/**
	 * Phone number for this Restaurant
	 * @var integer $restaurantPhone
	 */
	private $restaurantPhone;

	/**
	 * Star Rating for this Restaurant
	 * @var integer $restaurantStarRating
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
	 * @param integer $newRestaurantLat
	 * @param integer $newRestaurantLng
	 * @param string $newrestaurantName
	 * @param integer $newRestaurantPhone
	 * @param integer $newRestaurantStarRating
	 * @param string $newRestaurantUrl
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */

	public function __construct($newRestaurantId, string $newRestaurantAddress, string $newRestaurantAvatar, string $newRestaurantFoodType, integer $newRestaurantLat, integer $newRestaurantLng, string $newrestaurantName, integer $newRestaurantPhone, integer $newRestaurantStarRating, string $newRestaurantUrl) {
		try {
			$this->setRestaurantId($newRestaurantId);
			$this->setRestaurantAddress($newRestaurantAddress);
			$this->setRestaurantAvatar($newRestaurantAvatar);
			$this->setRestaurantFoodType($newRestaurantFoodType);
			$this->setRestaurantLat($newRestaurantLat);
			$this->setRestaurantLng($newRestaurantLng);
			$this->setRestaurantName($newrestaurantName);
			$this->setRestaurantPhone($newRestaurantPhone);
			$this->setRestaurantStarRating($newRestaurantStarRating);
			$this->setRestaurantUrl($newRestaurantUrl);


		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}





}