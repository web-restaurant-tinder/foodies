<?php
namespace WebRestaurantTinder\Foodies;

require_once("autoload.php");
require_once (dirname(__DIR__) . "/vendor/autoload.php");


use http\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid;

/**
 * This class was created to allow profiles to follow each other
 * @author Francisco Gallegos <fgallegos59@cnm.edu>
 */

class Follow implements \JsonSerializable {
    use ValidateDate;
    use ValidateUuid;

    /**
     * Id for the followed profile; this is the foreign key
     * @var Uuid $followFollowedProfileId
     */

    private $followFollowedProfileId;

    /**
     * Id for the profile following another profile; this is a foreign key
     * @var Uuid $followProfileId
     */

    private $followProfileId;

    /**
     * Date that the profile was followed
     *  @var \DateTime $newFollowDate
     */

    private $followDate;

    /**
     * constructor method for this class
     *
     * @param string|Uuid $newFollowFollowedProfileId id of this followed profile
     * @param string|Uuid $newFollowProfileId id of the profile following other profile
     * @param \DateTime|string|null $newFollowDate date and time follow occurs
     */
    public function __construct($newFollowFollowedProfileId, $newFollowProfileId, $newFollowDate = null)
    {
        try {
            $this->setFollowFollowedProfileId($newFollowFollowedProfileId);
            $this->setFollowProfileId($newFollowProfileId);
            $this->setFollowDate($newFollowDate);
        }
        catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor method for follow
     * @return Uuid value of followed profile id
     */
    public function getFollowFollowedProfileId(): Uuid
    {
        return ($this->followFollowedProfileId);
    }

    /**
     *mutator method for follow followed profile id
     *
     * @param mixed $newFollowFollowedProfileId
     * @throws \RangeException if $newFollowFollowedProfileId is not positive
     * @throws \TypeError if $newFollowFollowedProfileId is not an integer
     */
    public function setFollowFollowedProfileId($newFollowFollowedProfileId): void{
        try {
            $uuid = self::validateUuid($newFollowFollowedProfileId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        $this->followFollowedProfileId = $uuid;
    }

    /**
     * accessor method for follow profile id
     * @return Uuid value of follow profile id
     */
    public function getFollowProfileId(): Uuid
    {
        return $this->followProfileId;
    }

    /**
     * mutator method for follow profile id
     *
     * @param string | Uuid $newFollowProfileId new value of follow profile id
     * @throws \RangeException if $newFollowProfileId is not positive
     * @throws \TypeError if $newFollowProfileId is not uuid or string
     */
    public function setFollowProfileId( $newFollowProfileId ) : void {
        try {
            $uuid = self::validateUuid($newFollowProfileId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw (new $exceptionType($exception->getMessage(), 0, $exception));
        }

        $this->followProfileId = $uuid;

    }

    /**
     * accessor method for follow date
     *
     * @return \DateTime value of follow date
     */
    public function getFollowDate(): \DateTime
    {
        return $this->followDate;
    }

    /**
     * mutator method for follow date
     *
     * @param \DateTime|string|null $newFollowDate follow date as a DateTime object or string
     * @throws \InvalidArgumentException if $newFollowDate is not a valid object or string
     * @throws \RangeException of $newFollowDate is date that does not exist
     * @throws \Exception
     */
    public function setFollowDate($newFollowDate = null) : void {

        if ($newFollowDate === null) {
            $this->followDate = new  \DateTime();
            return;
        }

        try {
            $newFollowDate = self::validateDateTime($newFollowDate);
        } catch (\InvalidArgumentException | \RangeException $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        $this->followDate= $newFollowDate;
    }

    /**
     * inserts this Follown class into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @return array
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     */
    public function insert(\PDO $pdo) : void {
        //create query template
        $query = "INSERT INTO follow(followFollowedProfileId, followProfileId, followDate) VALUES(:followFollowedProfileId, :followProfileId, :followDate)";
        $statement = $pdo->prepare($query);

        //bind member variables to the place holders in the template
        $formattedDate = $this->followDate->format("Y-m-d H:i:s.u");
        $parameters = ["followFollowedProfileId" => $this->followFollowedProfileId->getBytes(), "followProfileId" => $this->followProfileId->getBytes(), "followDate" => $formattedDate];
        $statement->execute($parameters);
    }

    /**
     * deletes this Follow class for mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @return array
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     */
    public function delete(\PDO $pdo) : void {
        //create query template
        $query = "DELETE FROM follow WHERE followProfileId = :followProfileId AND followFollowedProfileId = :followFollowedProfileId";
        $statement = $pdo->prepare($query);

        //bind the member variables to the place holder in the template
        $parameters = ["followProfileId" => $this->followProfileId->getBytes(), "followFollowedProfileId" => $this->followFollowedProfileId->getBytes()];
        $statement->execute($parameters);
    }

//    /**
//     * @param \PDO $pdo PDO connection object
//     * @throws \PDOException when mySQL related error occurs
//     */
//    public function update(\PDO $pdo) : void {
//        //create query template
//        $query = "UPDATE follow SET followFollowedProfileId = :followFollowedProfileId, followProfileId = :followProfileId, followDate = :followDate WHERE followProfileId = :followProfileId ";
//        $statement = $pdo->prepare($query);
//
//        $formattedDate = $this->followDate->format("Y-m-d H:i:s.u");
//        $parameters = ["followFollowedProfileId" => $this->followFollowedProfileId->getBytes(), "followProfileId" => $this->followProfileId->getBytes(), "followDate" => $formattedDate];
//        $statement->execute($parameters);
//
//    }

    public static function getFollowByFollowProfileId(\PDO $pdo, string $followProfileId) : \SplFixedArray {
        //sanitize the followProfileId before searching
        try {
            $followProfileId = self::validateUuid($followProfileId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(),0, $exception));
        }

        //create query table
        $query = "SELECT followProfileId, followFollowedProfileId, followDate FROM follow WHERE followProfileId = :followProfileId";
        $statement = $pdo->prepare($query);

        //bind follow id to the place holder in the template
        $parameters = ["followProfileId" => $followProfileId->getBytes()];
        $statement->execute($parameters);

        //grab the follow id from mySQL
        $follows = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while (($row = $statement->fetch()) !== false) {
            try {
                $follow = new Follow($row["followProfileId"], $row["followFollowedProfileId"], $row["followDate"]);
                $follows[$follows->key()] = $follow;
                $follows->next();
            } catch (\Exception $exception) {
                //if the row could not be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($follows);
    }

    public static function getFollowByFollowProfileIdAndFollowFollowedProfileId(\PDO $pdo, string $followFollowedProfileId, string $followProfileId) : ?Follow {

        try {
            $followProfileId = self::validateUuid($followProfileId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        try {
            $followFollowedProfileId = self::validateUuid($followFollowedProfileId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }


        $query = "SELECT followFollowedProfileId, followProfileId, followDate FROM follow WHERE followProfileId = :followProfileId AND followFollowedProfileId = :followFollowedProfileId";
        $statement = $pdo->prepare($query);

        $parameters = ["followFollowedProfileId" => $followFollowedProfileId->getBytes(), "followProfileId" => $followProfileId->getBytes()];
        $statement->execute($parameters);

        try {
            $follow = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $follow = new Follow($row["followFollowedProfileId"], $row["followProfileId"], $row["followDate"]);
            }
        } catch (\Exception $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($follow);
    }

    public static function getFollowByFollowFollowedProfileId(\PDO $pdo, string $followFollowedProfileId): \SplFixedArray {
        try {
            $followFollowedProfileId = self::validateUuid($followFollowedProfileId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }

        $query = "SELECT followProfileId, followFollowedProfileId, followDate FROM follow WHERE followFollowedProfileId = :followFollowedProfileId";
        $statement = $pdo->prepare($query);

        $parameters = ["followFollowedProfileId" => $followFollowedProfileId->getBytes()];
        $statement->execute($parameters);

        $follows = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while (($row = $statement->fetch()) !== false) {
            try {
                $follow = new Follow($row["followFollowedProfileId"], $row["followProfileId"], $row["followDate"]);
                $follows[$follows->key()] = $follow;
                $follows->next();
            } catch (\Exception $exception) {
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
            return ($follows);
        }

    }

    /**
     * gets followed count by followProfileId
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $followFollowedProfileId profile id to search for
     * @return Follow|null Follow found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when a variable is not the correct data type
     */
    public static function getFollowCountByFollowFollowedProfileId(\PDO $pdo, $followFollowedProfileId) : int {
        //sanitize the followFollowedProfileId before searching

        try {
            $followFollowedProfileId = self::validateUuid($followFollowedProfileId);
        } catch (\InvalidArgumentException | \RangeException | \TypeError $exception) {
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }

        $query = "SELECT COUNT(*) FROM follow WHERE followFollowedProfileId = :followFollowedProfileId";
        $statement = $pdo->prepare($query);
        $parameters= ["followFollowedProfileId" => $followFollowedProfileId->getBytes()];
        $count = $statement->rowCount($parameters);
//        $follows = new \SplFixedArray($statement->rowCount());
//        $statement->setFetchMode(\PDO::FETCH_ASSOC);
//        while (($row = $statement->fetch()) !== false) {
//            try {
//                $follow = new Follow($row["followProfileId"], $row["followFollowedProfileId"], $row["followDate"]);
//                $follows[$follows->key()] = $follow;
//                $follows->next();
//            } catch (\Exception $exception) {
//                //if the row could not be converted, rethrow it
//                throw(new \PDOException($exception->getMessage(), 0, $exception));
//            }
//        }
        return($count);
    }

    /**
     * gets follow count by followProfileId
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $followProfileId profile id to search for
     * @return Follow|null Follow found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when a variable is not the correct data type
     */
    public static function getFollowCountByFollowProfileId(\PDO $pdo, $followProfileId) : ?Follow {
        //sanitize the followProfileId before searching
        try {
            $followProfileId = self::validateUuid($followProfileId);
        } catch (\InvalidArgumentException | \RangeException | \TypeError $exception) {
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }

        $query = "SELECT followFollowedProfileId, followProfileId, followDate FROM follow WHERE followProfileId = :followProfileId";
        $statement = $pdo->prepare($query);

        $parameters = ["followProfileId" => $followProfileId->getBytes()];
        $statement->execute($parameters);

        try {
            $follow = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $follow = new Follow($row["followProfileId"], $row["followFollowedProfileId"], $row["followDate"]);
            }
        } catch (\Exception $exception) {

            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($follow);
    }


    /**
     * formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     */
    public function jsonSerialize() : array {
        $fields = get_object_vars($this);

        $fields["followFollowedProfileId"] = $this->followFollowedProfileId->toString();
        $fields["followProfileId"] = $this->followProfileId->toString();

        //format the date so that the front end can consume it
        $fields["followDate"] = round(floatval($this->followDate->format("U.u")) * 1000);
        return($fields);
    }


}



