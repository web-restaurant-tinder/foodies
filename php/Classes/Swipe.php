<?php

namespace WebRestaurantTinder\Foodies;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use DateTime;
use Exception;
use InvalidArgumentException;
use JsonSerializable;
use PDO;
use PDOException;
use RangeException;
use SplFixedArray;
use TypeError;
use WebRestaurantTinder\Foodies\ValidateDate;
use WebRestaurantTinder\Foodies\ValidateUuid;
use Ramsey\Uuid\Uuid;

/**
 * This is the Swipe class
 * @swipe Sara Rendon <srendon4@cnm.edu>
 */
class Swipe implements JsonSerializable {

	use ValidateUuid;
	use ValidateDate;
	private $swipeProfileId;

	private $swipeRestaurantId;

	private $swipeDate;

	private $swipeRight;

	//private $swipeLeft;


	public function __construct($newSwipeProfileId, $newSwipeRestaurantId, $newSwipeDate, $newSwipeRight) {
//		var_dump($newSwipeProfileId, $newSwipeRestaurantId, $newSwipeDate, $newSwipeRight);
		try {
			$this->setSwipeProfileId($newSwipeProfileId);
			$this->setSwipeRestaurantId($newSwipeRestaurantId);
			$this->setSwipeDate($newSwipeDate);
			$this->setSwipeRight($newSwipeRight);
//			$this->setSwipeLeft($newSwipeLeft);

		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for Swipe Profile Id
	 *
	 * @return Uuid value of Swipe Profile Id
	 */
	public function getSwipeProfileId(): Uuid {
		return ($this->swipeProfileId);
	}

	/**
	 *mutator method for swipe id
	 *
	 * @param Uuid|string $newSwipeProfileId new value of SwipeProfile id
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if #newSwipeProfileId is out of range
	 * @throws TypeError if $newSwipeProfileId is not a uuid or string
	 */
	public function setSwipeProfileId($newSwipeProfileId): void {
		try {
			$Uuid = self::validateUuid($newSwipeProfileId);
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the Swipe Profile Id
		$this->swipeProfileId = $Uuid;
	}

	public function getSwipeRestaurantId(): Uuid {
		return $this->swipeRestaurantId;
	}

	/**
	 *mutator method for account Swipe Restaurant Id
	 *
	 * @param string $newSwipeRestaurantId
	 * @throws InvalidArgumentException if the id is not a string or is insecure
	 * @throws RangeException if the id is not exactly 32 characters
	 * @throws TypeError if the Swipe Restaurant Id is not a string
	 */
	public function setSwipeRestaurantId(string $newSwipeRestaurantId): void {
		try {
			$uuid = self::validateUuid($newSwipeRestaurantId);
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->swipeRestaurantId = $uuid;
	}

	/**
	 * accessor method for Swipe Date
	 *
	 * @return string this Swipe Date
	 */
	public function getSwipeDate() {
		return $this->swipeDate;
	}

	public function setSwipeDate($newSwipeDate): void {
		if($newSwipeDate === null) {
			$this->swipeDate = new DateTime();
			return;
		}
		try {
			$newSwipeDate = self::validateDateTime($newSwipeDate);

		} catch(InvalidArgumentException | RangeException $exception) {

			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->swipeDate = $newSwipeDate;
	}

	/**
	 * accessor method for swipe right
	 *
	 * @return string swipe right
	 */
	public function getSwipeRight(): string {
		return $this->swipeRight;
	}

	/**
	 * mutator method for swipe right
	 *
	 * @param string $newSwipeRight
	 * @throws InvalidArgumentException if the swipe is not an swipe or is insecure
	 * @throws RangeException if the swipe is more than 128 characters
	 * @throws TypeError if the swipe is not a string
	 */
	public function setSwipeRight($newSwipeRight): void {
		try {

			// verify the swipe right will fit in the database
			if($newSwipeRight != 1 && $newSwipeRight != 0) {
				throw(new RangeException("swipe right must be 1, 0 or NULL"));
			}
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->swipeRight = $newSwipeRight;
	}

//	/**
//	 * mutator for swipe left
//	 *
//	 * @param string $newSwipeLeft
//	 * @throws \InvalidArgumentException if the swipe left is not an argon swipe left or is insecure
//	 * @throws \RangeException if the swipe left is larger than 97 characters
//	 * @throws \TypeError if the swipe left is not a string
//	 */
//	public function setSwipeLeft(string $newSwipeLeft): void {
//		try {
//			//enforce that the Swipe Left is properly formatted
//			$newSwipeLeft = trim($newSwipeLeft);
//			if(empty($newSwipeLeft) === true) {
//				throw(new \InvalidArgumentException("swipe is empty"));
//			}
//
//		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
//			$exceptionType = get_class($exception);
//			throw(new $exceptionType($exception->getMessage(), 0, $exception));
//		}
//	}
///**
// * accessor for swipe left
// *
// * @return string this swipe left
// */
//public function getSwipeLeft(): string {
//	return $this->swipeLeft;
//}


	public function insert(PDO $pdo): void {
		//create query template
		$query = "INSERT INTO swipe(swipeProfileId, swipeRestaurantId, swipeDate, swipeRight) VALUES(:swipeProfileId, :swipeRestaurantId, :swipeDate,  :swipeRight)";
		$statement = $pdo->prepare($query);
		//bind member variables to the place holders in the template
		$formattedDate = $this->swipeDate->format("Y-m-d H:i:s.u");
		$parameters = ["swipeProfileId" => $this->swipeProfileId->getBytes(), "swipeRestaurantId" => $this->swipeRestaurantId->getBytes(), "swipeDate" => $formattedDate, "swipeRight" => $this->swipeRight];
		$statement->execute($parameters);
	}


	public function delete(PDO $pdo): void {
		//create query template
		$query = "DELETE FROM swipe WHERE swipeProfileId = :swipeProfileId AND swipeRestaurantId = :swipeRestaurantId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holder in the template
		$parameters = ["swipeProfileId" => $this->swipeProfileId->getBytes(), "swipeRestaurantId" => $this->swipeRestaurantId->getBytes()];
		$statement->execute($parameters);
	}


	public static function getSwipeBySwipeProfileId(PDO $pdo, string $swipeProfileId): SplFixedArray {
		//sanitize the swipeProfileId before searching
		try {
			$swipeProfileId = self::validateUuid($swipeProfileId);
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}

		//create query table
		$query = "SELECT swipeProfileId, swipeRestaurantId, swipeDate, swipeRight FROM swipe WHERE swipeProfileId = :swipeProfileId";
		$statement = $pdo->prepare($query);

		//bind swipe id to the place holder in the template
		$parameters = ["swipeProfileId" => $swipeProfileId->getBytes()];
		$statement->execute($parameters);

		//grab the swipe id from mySQL
		$swipes = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$swipe = new Swipe($row["swipeProfileId"], $row["swipeRestaurantId"], $row["swipeDate"], $row["swipeRight"]);
				$swipes[$swipes->key()] = $swipe;
				$swipes->next();
			} catch(Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($swipes);
	}

	public static function getSwipeBySwipeProfileIdAndSwipeRestaurantId(PDO $pdo, string $swipeProfileId, string $swipeRestaurantId): ?Swipe {

		try {
			$swipeProfileId = self::validateUuid($swipeProfileId);
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}

		try {
			$swipeRestaurantId = self::validateUuid($swipeRestaurantId);
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}


		$query = "SELECT swipeProfileId, swipeRestaurantId, swipeDate, swipeRight FROM swipe WHERE swipeProfileId = :swipeProfileId 
      AND swipeRestaurantId = :swipeRestaurantId";
		$statement = $pdo->prepare($query);

		$parameters = ["swipeProfileId" => $swipeProfileId->getBytes(), "swipeRestaurantId" => $swipeRestaurantId->getBytes()];
		$statement->execute($parameters);

		try {
			$swipe = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$swipe = new Swipe($row["swipeProfileId"], $row["swipeRestaurantId"], $row["swipeDate"], $row["swipeRight"]);
			}
		} catch(Exception $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($swipe);
	}


	public static function getSwipeBySwipeRestaurantId(PDO $pdo, string $swipeRestaurantId): SplFixedArray {
		try {
			$swipeRestaurantId = self::validateUuid($swipeRestaurantId);
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
			throw (new PDOException($exception->getMessage(), 0, $exception));
		}

		$query = "SELECT swipeProfileId, swipeRestaurantId, swipeDate, swipeRight FROM swipe WHERE swipeRestaurantId = :swipeRestaurantId";
		$statement = $pdo->prepare($query);

		$parameters = ["swipeRestaurantId" => $swipeRestaurantId->getBytes()];
		$statement->execute($parameters);

		$swipes = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$swipe = new Swipe($row["swipeProfileId"], $row["swipeRestaurantId"], $row["swipeDate"], $row["swipeRight"]);
				$swipes[$swipes->key()] = $swipe;
				$swipes->next();
			} catch(Exception $exception) {
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}


		}
		return ($swipes);
	}


	/**
	 * @inheritDoc
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["swipeProfileId"] = $this->swipeProfileId->toString();
		$fields["swipeRestaurantId"] = $this->swipeRestaurantId->toString();
		$fields["swipeDate"] = round(floatval($this->swipeDate->format("U.u")) * 1000);
		return ($fields);
	}
}