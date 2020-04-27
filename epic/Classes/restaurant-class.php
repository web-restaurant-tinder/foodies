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

		// verify the Todo Restaurant will fit in the database
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

		// verify the Todo Restaurant will fit in the database
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

		// verify the Todo Restaurant will fit in the database
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
	 * inserts this restaurant into SQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function insert(\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO restaurant(restaurantId, restaurantAddress, restaurantAvatar, restaurantFoodType, restaurantLat, restaurantLng, restaurantName, restaurantPhone, restaurantStarRating, restaurantUrl) VALUES (:restaurantId, :restaurantAddress, :restaurantAvatar, :restaurantFoodType, :restaurantLat, :restaurantLng, :restaurantName, :restaurantPhone, :restaurantStarRating, :restaurantUrl)";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["restaurantId"=>$this->restaurantId->getBytes(), "restaurantAddress"=> $this->restaurantAddress, "restaurantAvatar"=> $this->restaurantAvatar, "restaurantFoodType"=> $this->restaurantFoodType, "restaurantLat"=> $this->restaurantLat, "restaurantLng"=> $this->restaurantLng, "restaurantName"=> $this->restaurantName, "restaurantPhone"=> $this->restaurantPhone, "restaurantStarRating"=> $this->restaurantStarRating, "restaurantUrl"=> $this->restaurantUrl,];
		$statement->execute($parameters);
	}

	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM restaurant WHERE restaurantId = :restaurantId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["restaurantId" => $this->restaurantId()->getBytes()];
		$statement->execute($parameters);
	}

	public function update(\PDO $pdo) : void {
		//create query template
		$query = "UPDATE restaurant SET restaurantAddress = :restaurantAddress, 
    restaurantAvatar = :restaurantAvatar, restaurantFoodType = :restaurantFoodType, restaurantLat = :restaurantLat, restaurantLng = :restaurantLng, 
    restaurantName = :restaurantName, restaurantPhone = :restaurantPhone, restaurantStarRating = :restaurantStarRating, restaurantUrl = :restaurantUrl";

		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["restaurantId"=>$this->restaurantId->getBytes(),
			"restaurantAddress"=> $this->restaurantAddress,
			"restaurantAvatar"=> $this->restaurantAvatar,
			"restaurantFoodType"=> $this->restaurantFoodType,
			"restaurantLat"=> $this->restaurantLat,
			"restaurantLng"=> $this->restaurantLng,
			"restaurantName"=> $this->restaurantName,
			"restaurantPhone"=> $this->restaurantPhone,
			"restaurantStarRating"=> $this->restaurantStarRating,
			"restaurantUrl"=> $this->restaurantUrl];

		$statement->execute($parameters);
	}

	/**
	 * get restaurantByRestaurantId from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $restaurantId restaurant Id
	 * @return Restaurant|null Restaurant found or null if not found
	 * @throws \PDOException when my SQL related
	 * @throws \TypeError when a variable are not the correct data type
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if restaurant Id is out of range
	 */

	public static function getRestaurantByRestaurantId(\PDO $pdo, $restaurantId) : ?Restaurant {
		// sanitize the restaurantId before searching
		try {
			$restaurantId = self::validateUuid($restaurantId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT restaurantId, restaurantAddress, restaurantAvatar, restaurantFoodType, restaurantLat, restaurantLng, restaurantName, restaurantPhone, restaurantStarRating, restaurantUrl FROM restaurant WHERE restaurantId = :restaurantId";
		$statement = $pdo->prepare($query);

		// bind the restaurant id to the place holder in the template
		$parameters = ["restaurantId" => $restaurantId->getBytes()];
		$statement->execute($parameters);

		// grab the restaurant from mySQL
		try {
			$restaurant = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$restaurant = new Restaurant($row["restaurantId"], $row["restaurantAddress"], $row["restaurantAvatar"], $row["restaurantFoodType"], $row["restaurantLat"], $row["restaurantLng"], $row["restaurantName"], $row["restaurantPhone"], $row["restaurantStarRating"], $row["restaurantUrl"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($restaurant);
	}

	/**
	 * get restaurantByRestaurantFoodType from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $restaurantId
	 * @param string $restaurantFoodType
	 * @return Restaurant|null Restaurant found or null if not found
	 * @throws \PDOException when my SQL related
	 * @throws \TypeError when a variable are not the correct data type
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if restaurant Id is out of range
	 */

	public static function getRestaurantByRestaurantFoodType(\PDO $pdo, string $restaurantFoodType) : \SplFixedArray {
		// sanitize the description before searching
		$restaurantFoodType = trim($restaurantFoodType);
		$restaurantFoodType = filter_var($restaurantFoodType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($restaurantFoodType) === true) {
			throw(new \PDOException("Restaurant Food Type is invalid"));
		}

		// escape any mySQL wild cards
		$restaurantFoodType = str_replace("_", "\\_", str_replace("%", "\\%", $restaurantFoodType));

		// create query template
		$query = "SELECT restaurantId, restaurantAddress, restaurantAvatar, restaurantFoodType, restaurantLat, restaurantLng, restaurantName, restaurantPhone, restaurantStarRating, restaurantUrl FROM restaurant WHERE restaurantFoodType LIKE :restaurantFoodType";
		$statement = $pdo->prepare($query);

		// bind the restaurant Food Type to the place holder in the template
		$res = "%$restaurantFoodType%";
		$parameters = ["restaurantFoodType" => $restaurantFoodType];
		$statement->execute($parameters);

		// build an array of restaurants
		$restaurants = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$restaurant = new Restaurant($row["restaurantId"], $row["restaurantAddress"], $row["restaurantAvatar"], $row["restaurantFoodType"], $row["restaurantLat"], $row["restaurantLng"], $row["restaurantName"], $row["restaurantPhone"], $row["restaurantStarRating"], $row["restaurantUrl"]);
				$restaurants[$restaurants->key()] = $restaurant;
				$restaurants->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($restaurants);
	}

	/**
	 * get restaurantByRestaurantName from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $restaurantId
	 * @param string $restaurantName
	 * @return Restaurant|null Restaurant found or null if not found
	 * @throws \PDOException when my SQL related
	 * @throws \TypeError when a variable are not the correct data type
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if restaurant Id is out of range
	 */

	public static function getRestaurantByRestaurantName(\PDO $pdo, string $restaurantName) : \SplFixedArray {
		// sanitize the description before searching
		$restaurantName = trim($restaurantName);
		$restaurantName = filter_var($restaurantName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($restaurantName) === true) {
			throw(new \PDOException("Restaurant Name is invalid"));
		}

		// escape any mySQL wild cards
		$restaurantName = str_replace("_", "\\_", str_replace("%", "\\%", $restaurantName));

		// create query template
		$query = "SELECT restaurantId, restaurantAddress, restaurantAvatar, restaurantFoodType, restaurantLat, restaurantLng, restaurantName, restaurantPhone, restaurantStarRating, restaurantUrl FROM restaurant WHERE restaurantName LIKE :restaurantName";
		$statement = $pdo->prepare($query);

		// bind the restaurant name to the place holder in the template
		$res = "%$restaurantName%";
		$parameters = ["restaurantName" => $restaurantName];
		$statement->execute($parameters);

		// build an array of restaurants
		$restaurants = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$restaurant = new Restaurant($row["restaurantId"], $row["restaurantAddress"], $row["restaurantAvatar"], $row["restaurantFoodType"], $row["restaurantLat"], $row["restaurantLng"], $row["restaurantName"], $row["restaurantPhone"], $row["restaurantStarRating"], $row["restaurantUrl"]);
				$restaurants[$restaurants->key()] = $restaurant;
				$restaurants->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($restaurants);
	}
}