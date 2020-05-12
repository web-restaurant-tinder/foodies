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
    private $VALID_FOLLOW_FOLLOWED_PROFILE_ID = null;

    /**
     * profile that is following another profile; this is for foreign key relations
     * @var profile
     */
    private $VALID_FOLLOW_PROFILE_ID = null;

    /**
     * timestamp of when a profile is followed
     * @var \DateTime $VALID_FOLLOW_DATE
     */
    private $VALID_FOLLOW_DATE = null;

    /**
     *
     */
    public function testInsertValidFollow() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $followProfileId = generateUuidV4()->toString();
        $follow = new Follow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $this->VALID_FOLLOW_PROFILE_ID, $this->VALID_FOLLOWDATE);
        $follow->insert($this->getPDO());

        $numRowsAfterInsert = $this ->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        self::assertEquals($followProfileId, $pdoFollow->getFollowProfileId());
        self::assertEquals($this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $pdoFollow->getFollowFollowedProfileId());
        self::assertEquals($this->VALID_FOLLOWDATE, $pdoFollow->getFollowDate());


    }

    public function testUpdateValidFollow() : void {
        $numRows = $this->getConnection()->getRowCount("follow");
        $followProfileId = generateUuidV4()->getRowCount("follow");
        $follow = new Follow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());

        $changedFollowProfile = $this->VALID_PROFILE . "changed";
        $follow->setFollowProifle($changedFollowProfile);
        $follow->update($this->getPDO());

        $numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        self::assertEquals($followProfileId, $pdoFollow->getFollowProfileId());
        self::assertEquals($this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $pdoFollow->getFollowFollowedProfileId());
        self::assertEquals($this->VALID_FOLLOW_PROFILE_ID, $pdoFollow->getFollowProfileId());
        self::assertEquals($this->VALID_FOLLOW_DATE, $pdoFollow->getFollowDate());

        self::assertEquals($changedFollowProfile, $pdoFollow->getFollowProfile());
    }


    public function testDeleteValidFollow() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $rowsInserted = 2;

        for ($i=0; $i<$rowsInserted; $i++){
            $followProfileId = generateUuidV4()->toString();
            $follow = new Follow($followProfileId, $this->VALID_FOLLOW_PROFILE_ID,
                $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID,
                $this->VALID_FOLLOW_DATE . $i);
            $follow->insert($this->getPDO());
        }

        $numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + $rowsInserted, $numRowsAfterInsert);

        $follow->delete($this->getPDO);

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());

        $numRowsAfterDelete = $this->getConnection()->getRowCount("follow");
        self::assertsEquals($numRows + $rowsInserted - 1, $numRowsAfterDelete);

    }

    public function testGetValidFollowByFollowProfileId() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $followProfileId = generateUuidV4()->toString();
        $follow = new Follow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());

        $numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        self::assertEquals($pdoFollow->getFollowProfileId(), followProfileId);
        self::assertEquals($pdoFollow->getFollowFollowedProfileId(), $followProfileId);
        self::assertEquals($pdoFollow->getFollowDate(), $this->VALID_FOLLOW_DATE);
    }

    public function testGetValidFollows() : void {
        $numRows = $this->getConnection()->getRowCount("follow");
        $rowsInserted = 5;

        for ($i=0; $i<$rowsInserted; $i++){
            $followProfileId = generateUuidV4()->toString();
            $follow = newFollow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID,
                 $this->VALID_FOLLOW_PROFILE_ID,
                 $this->VALID_FOLLOWDATE . i);
            $follow->insert($this->getPDO());
        }

        self::assertsEquals($numRows + $rowsInserted, $this->getConnection()->getRowCount("follow"));

        self::assertsEquals($numRows + $rowsInserted, $follow->getAllFollows($this->getPDO())->count());
    }


}
