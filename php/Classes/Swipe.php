<?php
namespace WebRestaurantTinder\Foodies;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Sararendon01\TinderRestaurant\ValidateDate;
use Sararendon01\TinderRestaurant\ValidateUuid;
use Ramsey\Uuid\Uuid;

/**
 * This is the Swipe class
 * @author Sara Rendon <srendon4@cnm.edu>
 */
class Swipe implements \JsonSerializable
{

	use ValidateUuid;
	use ValidateDate;
	private $swipeProfileId;

	private $swipeRestaurantId;

	private $swipeDate;

	private  $swipeRight;

	private $swipeLeft;



	public function __construct($newSwipeProfileId, string $newSwipeRestaurantId, string $newSwipeDate, string $newSwipeRight, string $newSwipeLeft)
	{
		try {
			$this->setSwipeProfileId($newSwipeProfileId);
			$this->setSwipeRestaurantId($newSwipeRestaurantId);
			$this->setSwipeDate($newSwipeDate);
			$this->setSwipeRight($newSwipeRight);
			$this->setSwipeLeft($newSwipeLeft);

		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for Swipe Profile Id
	 *
	 * @return Uuid value of Swipe Profile Id
	 */
	public function getSwipeProfileId(): Uuid
	{
		return ($this->SwipeProfileId);
	}

	/**
	 *mutator method for author id
	 *
	 * @param Uuid|string $newSwipeProfileId new value of SwipeProfile id
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if #newSwipeProfileId is out of range
	 * @throws \TypeError if $newSwipeProfileId is not a uuid or string
	 */
	public function setSwipeProfileId($newSwipeProfileId): void
	{
		try {
			$uuid = self::validateUuid($newSwipeProfileId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the Swipe Profile Id
		$this->SwipeProfileId = $uuid;
	}

	/**
	 * accessor method for author Swipe Restaurant Id
	 *
	 * @return string value of the Swipe Restaurant Id
	 */
	public function getSwipeRestaurantId(): ?string
	{
		return $this->swipeRestaurantId;
	}

	/**
	 *mutator method for account Swipe Restaurant Id
	 *
	 * @param string $newSwipeRestaurantId
	 * @throws \InvalidArgumentException if the id is not a string or is insecure
	 * @throws \RangeException if the id is not exactly 32 characters
	 * @throws \TypeError if the Swipe Restaurant Id is not a string
	 */
	public function setSwipeRestaurantId(?string $newSwipeRestaurantId): void
	{

		if ($newSwipeRestaurantId === null) {
			$this->SwipeRestaurantId = null;
			return;
		}

		try {
			$newSwipeRestaurantId = strtolower(trim($newSwipeRestaurantId));
			if (ctype_xdigit($newSwipeRestaurantId) === false) {
				throw(new\RangeException("swipe restaurant is not valid"));
			}

			//make sure user Swipe Restaurant is only 32 characters
			if (strlen($newSwipeRestaurantId) !== 32) {
				throw(new\RangeException("swipe restaurant token has to be 32 characters"));
			}
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->swipeRestaurantId = $newSwipeRestaurantId;
	}

	/**
	 * accessor method for Swipe Date
	 *
	 * @return string this Swipe Date
	 */
	public function getSwipeDate(): string
	{
		return $this->SwipeDate;
	}

	/**
	 * mutator method for SwipeDate
	 *
	 * @param string $SwipeDate
	 * @throws \InvalidArgumentException if the Swipe Date is not a string or is insecure
	 * @throws \RangeException if the Swipe Date is not more than 255 characters
	 * @throws \TypeError if the Swipe Date is not a string
	 */
	public function setSwipeDate(?string $newSwipeDate): void
	{

		$newSwipeDate = trim($newSwipeDate);
		$newSwipeDate = filter_var($newSwipeDate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		try {
			// verify the Swipe Date will fit in the database
			if (strlen($newSwipeDate) > 255) {
				throw(new \RangeException("date too long, must be less than 256 characters"));
			}
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->SwipeDate = $newSwipeDate;
	}

	/**
	 * accessor method for swipe right
	 *
	 * @return string swipe right
	 */
	public function getSwipeRight(): string
	{
		return $this->SwipeRight;
	}

	/**
	 * mutator method for swipe right
	 *
	 * @param string $newSwipeRight
	 * @throws \InvalidArgumentException if the swipe is not an swipe or is insecure
	 * @throws \RangeException if the swipe is more than 128 characters
	 * @throws \TypeError if the swipe is not a string
	 */
	public function setSwipeRight(string $newSwipeRight): void
	{
		try {
			// verify the Swipe Right is secure
			$newSwipeRight = trim($newSwipeRight);
			$newSwipeRight = filter_var($newSwipeRight, FILTER_VALIDATE_EMAIL);
			if (empty($newSwipeRight) === true) {
				throw(new \InvalidArgumentException("swipe right is empty or insecure"));
			}

			// verify the swipe right will fit in the database
			if (strlen($newSwipeRight) > 128) {
				throw(new \RangeException("swipe right is too large"));
			}
		}catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->SwipeRight = $newSwipeRight;
	}

	/**
	 * accessor for swipe left
	 *
	 * @return string this swipe left
	 */
	public function getSwipeLeft(): string
	{
		return $this->swipeleft;
	}

	/**
	 * mutator for swipe left
	 *
	 * @param string $newSwipeLeft
	 * @throws \InvalidArgumentException if the swipe left is not an argon swipe left or is insecure
	 * @throws \RangeException if the swipe left is larger than 97 characters
	 * @throws \TypeError if the swipe left is not a string
	 */
	public function setSwipeLeft(string $newSwipeLeft): void
	{
		try {
			//enforce that the Swipe Left is properly formatted
			$newSwipeLeft = trim($newSwipeLeft);
			if(empty($newSwipeLeft) === true)
				}

			// verify the Swipe Left will fit in the database
			if (strlen($newSwipeLeft) > 97) {
				throw(new \RangeException("Swipe Left is too large"));
			}
		}catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->SwipeLeft = $newSwipeLeft;
	}

/**
 * @inheritDoc
 */
public function jsonSerialize()
{
	$fields = get_object_vars($this);
	$fields["authorId"] = $this->authorId->toString();
	unset($fields["authorActivationToken"]);
	unset($fields["authorHash"]);
	return ($fields);
}
}