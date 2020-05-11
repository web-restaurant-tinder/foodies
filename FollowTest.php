<?php
namespace WebRestaurantTinder\Foodies\Test;

use WebRestaurantTinder\Foodies\{Follow};

require_once (dirname(__DIR__) . "/Test/DataDesignTest.php");

require_once (dirname(__DIR__). "/autoload.php");

require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

class FollowTest extends DataDesignTest {
    /**
     * profile that is being followed by another profile; this is for foreign key relations
     * @var
     */
    private $followFollowedProfileId = null;

    /**
     * profile that is following another profile; this is for foreign key relations
     * @var profile
     */
    private $followProfileId = null;

    /**
     * timestamp of when a profile is followed
     * @var \DateTime $VALID_FOLLOWDATE
     */
    private $VALID_FOLLOWDATE = null;

    /**
     *
     */
    public function testInsertValidFollow() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $followProfileId = generateUuidV4()->toString();
        $follow = new Follow($followProfileId, $this->Valid_Followed_Profile_Id, $this->Valid_Follow_Profile_Id, $this->Valid_Follow_Date);
        $follow->insert($this->getPDO());

        $numRowsAfterInsert = $this ->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        self::assertEquals($followProfileId, $pdoFollow->getFollowProfileId());
        self::assertEquals($this->followFollowedProfileId, $pdoFollow->getFollowFollowedProfileId());
        self::assertEquals($this->VALID_FOLLOWDATE, $pdoFollow->getFollowDate());


    }

    public function testGetValidFollowByFollowProfileId() : void {
        $numRows = $this->getConnection()->getRowCount("follow");
    }


}
