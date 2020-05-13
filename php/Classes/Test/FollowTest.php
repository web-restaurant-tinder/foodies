<?php
namespace WebRestaurantTinder\Foodies\Test;

use WebRestaurantTinder\Foodies\Follow;

require_once(dirname(__DIR__) . "/Test/DataDesignTest.php");

require_once(dirname(__DIR__) . "/autoload.php");

require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

class FollowTest extends DataDesignTest {

    private $VALID_FOLLOW_FOLLOWED_PROFILE_ID = null;
    private $VALID_FOLLOW_PROFILE_ID = null;
    private $VALID_FOLLOW_DATE = null;


    public function testInsertValidFollow() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $followProfileId = generateUuidV4()->toString();
        $follow = new Follow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());

        $numRowsAfterInsert = $this ->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        self::assertEquals($followProfileId, $pdoFollow->getFollowProfileId());
        self::assertEquals($this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $pdoFollow->getFollowFollowedProfileId());
        self::assertEquals($this->VALID_FOLLOW_DATE, $pdoFollow->getFollowDate());


    }

    public function testUpdateValidFollow() : void {
        $numRows = $this->getConnection()->getRowCount("follow");
        $followProfileId = generateUuidV4()->getRowCount("follow");
        $follow = new Follow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());
        $follow->update($this->getPDO());


        $numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        self::assertEquals($followProfileId, $pdoFollow->getFollowProfileId());
        self::assertEquals($this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $pdoFollow->getFollowFollowedProfileId());
        self::assertEquals($this->VALID_FOLLOW_PROFILE_ID, $pdoFollow->getFollowProfileId());
        self::assertEquals($this->VALID_FOLLOW_DATE, $pdoFollow->getFollowDate());

    }


    public function testDeleteValidFollow() : void {
        //count number of rows
        $numRows = $this->getConnection()->getRowCount("follow");

        $followProfileId = generateUuidV4();
        $follow = new Follow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());


        //delete the Follow from mySQl
        $this->assertsEquals($numRows + 1, $this->getConnection()->getRowCount("follow"));
        $follow->delete($this->getPDO);

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId());
        $this->assertNull($pdoFollow);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("follow"));

    }

    public function testGetValidFollowByFollowProfileId() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $followProfileId = generateUuidV4()->toString();
        $follow = new Follow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());

        $numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        self::assertEquals($pdoFollow->getFollowProfileId(), $followProfileId);
        self::assertEquals($pdoFollow->getFollowFollowedProfileId(), $followProfileId);
        self::assertEquals($pdoFollow->getFollowDate(), $this->VALID_FOLLOW_DATE);
    }

    public function testGetValidFollowCountByFollowFollowedProfileId() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $followProfileId = generateUuidV4()->toString();
        $follow = new Follow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());

        $numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        self::assertEquals($pdoFollow->getFollowProfileId(), $followProfileId);
        self::assertEquals($pdoFollow->getFollowFollowedProfileId(), $followProfileId);
        self::assertEquals($pdoFollow->getFollowDate(), $this->VALID_FOLLOW_DATE);
    }

    public function testGetValidFollowCountByFollowProfileId() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $followProfileId = generateUuidV4()->toString();
        $follow = new Follow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());

        $numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        self::assertEquals($pdoFollow->getFollowProfileId(), $followProfileId);
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
                 $this->VALID_FOLLOW_DATE);
            $follow->insert($this->getPDO());
        }

        self::assertsEquals($numRows + $rowsInserted, $this->getConnection()->getRowCount("follow"));

        self::assertsEquals($numRows + $rowsInserted, $follow->getAllFollows($this->getPDO())->count());
    }


}
