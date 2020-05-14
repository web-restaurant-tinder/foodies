<?php
namespace WebRestaurantTinder\Foodies\Test;

use WebRestaurantTinder\Foodies\Follow;
use WebRestaurantTinder\Foodies\Profile;

require_once(dirname(__DIR__) . "/autoload.php");

require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

class FollowTest extends DataDesignTest {

    private $profile;
    private $followedProfile;
    private $VALID_FOLLOW_FOLLOWED_PROFILE_ID = null;
    private $VALID_FOLLOW_PROFILE_ID = null;
    private $VALID_FOLLOW_DATE = null;
    private $VALID_HASH;
    private $VALID_ACTIVATION;


    public final function setUp(): void {
        parent::setUp();
        // create a salt and hash for the mocked profile
        $password = "abc123";
        $this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 8]);
        $this->VALID_ACTIVATION = bin2hex(random_bytes(16));

        $this->profile = new Profile(generateUuidV4(),  $this->VALID_ACTIVATION, "abhckb", "https://vsgdsd.com",
        "gfhd@gmail.com", "Jim",  $this->VALID_HASH, "Johnson", "gsdsda" );
        $this->profile->insert($this->getPDO());

        $this->followedProfile = new Profile(generateUuidV4(),  $this->VALID_ACTIVATION, "kishsjb", "https://lutchj.com",
            "ghdka@gmail.com", "Francisco",  $this->VALID_HASH, "Gallegos", "lasscsc" );
        $this->followedProfile->insert($this->getPDO());

        $this->VALID_FOLLOW_DATE = new \DateTime();
    }

    public function testInsertValidFollow() : void {
        $numRows = $this->getConnection()->getRowCount("follow");
        var_dump($this->profile->getProfileId()->toString(), $this->followedProfile->getProfileId()->toString());
        $follow = new Follow($this->profile->getProfileId()->toString(), $this->followedProfile->getProfileId()->toString(), $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());
        var_dump($follow);
        $numRowsAfterInsert = $this ->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowByFollowProfileIdAndFollowFollowedProfileId($this->getPDO(), $follow->getFollowProfileId()->toString(), $follow->getFollowFollowedProfileId()->toString());
        $this->assertEquals($this->profile->getProfileId(), $pdoFollow->getFollowProfileId());
        $this->assertEquals( $this->followedProfile->getProfileId(), $pdoFollow->getFollowFollowedProfileId());
        $this->assertEquals($this->VALID_FOLLOW_DATE, $pdoFollow->getFollowDate());


    }

//    public function testUpdateValidFollow() : void {
//        $numRows = $this->getConnection()->getRowCount("follow");
//        $followProfileId = generateUuidV4()->getRowCount("follow");
//        $follow = new Follow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $this->VALID_FOLLOW_DATE);
//        $follow->insert($this->getPDO());
//        $follow->update($this->getPDO());
//
//
//        $numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
//        self::assertEquals($numRows + 1, $numRowsAfterInsert);
//
//        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
//        self::assertEquals($followProfileId, $pdoFollow->getFollowProfileId());
//        self::assertEquals($this->VALID_FOLLOW_FOLLOWED_PROFILE_ID, $pdoFollow->getFollowFollowedProfileId());
//        self::assertEquals($this->VALID_FOLLOW_PROFILE_ID, $pdoFollow->getFollowProfileId());
//        self::assertEquals($this->VALID_FOLLOW_DATE, $pdoFollow->getFollowDate());
//
//    }
//

    public function testDeleteValidFollow() : void {
        //count number of rows
        $numRows = $this->getConnection()->getRowCount("follow");

        $follow = new Follow($this->profile->getProfileId()->toString(), $this->followedProfile->getProfileId()->toString(), $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());


        //delete the Follow from mySQl
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("follow"));
        $follow->delete($this->getPDO());

        $pdoFollow = Follow::getFollowByFollowProfileIdAndFollowFollowedProfileId($this->getPDO(), $follow->getFollowProfileId()->toString(), $follow->getFollowFollowedProfileId()->toString());
        $this->assertNull($pdoFollow);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("follow"));

    }

    public function testGetValidFollowByFollowProfileIdAndFollowFollowedProfileId() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $follow = new Follow($this->profile->getProfileId()->toString(), $this->followedProfile->getProfileId()->toString(), $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());

        $pdoFollow = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("follow"));
        $this->assertEquals($pdoFollow->getFollowProfileId(), $follow->getFollowProfileId());
        $this->assertEquals($pdoFollow->getFollowFollowedProfileId(), $follow->getFollowFollowedProfileId());

        $this->assertEquals($pdoFollow->getFollowDate()->getTimeStamp(), $this->VALID_FOLLOW_DATE->getTimestamp());

    }

    public function testGetInvalidFollowByFollowProfileAndFollowFollowedProfileId() : void {
        $follow = Follow::getFollowByFollowProfileIdAndFollowFollowedProfileId($this->getPDO(), generateUuidV4(), generateUuidV4());
        $this->assertNull($follow);
    }

    public function testGetValidFollowByFollowProfileId() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $follow = new Follow($this->profile->getProfileId()->toString(), $this->followedProfile->getProfileId()->toString(), $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());

        $results = Follow::getFollowByFollowProfileId($this->getPDO(), $follow->getFollowProfileId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("follow"));
        $this->assertCount(1, $results);
        $this->assertContainsOnlyInstancesOf("\\Follow",$results);

        $pdoFollow = $results[0];
        $this->assertEquals($pdoFollow->getFollowProfileId(), $follow->getFollowProfileId());
        $this->assertEquals($pdoFollow->getFollowFollowedProfileId(), $follow->getFollowFollowedProfileId());

        $this->assertEquals($pdoFollow->getFollowDate()->getTimeStamp(), $this->VALID_FOLLOW_DATE->getTimestamp());

    }

    public function testGetInvalidFollowByFollowProfileId() : void {
        $follow = Follow::getFollowByFollowProfileId($this->getPDO(),generateUuidV4());
        $this->assertCount(0, $follow);
    }

    public function testGetValidFollowCountByFollowFollowedProfileId() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $follow = new Follow($this->profile->getProfileId()->toString(), $this->followedProfile->getProfileId()->toString(), $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());

        $numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowCountByFollowFollowedProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        var_dump($pdoFollow);
//        self::assertEquals($this->profile->getProfileId(), $pdoFollow->getFollowProfileId());
//        self::assertEquals( $this->followedProfile->getProfileId(), $pdoFollow->getFollowFollowedProfileId());
//        self::assertEquals($pdoFollow->getFollowDate(), $this->VALID_FOLLOW_DATE);
    }

    public function testGetValidFollowCountByFollowProfileId() : void {
        $numRows = $this->getConnection()->getRowCount("follow");

        $follow = new Follow($this->profile->getProfileId()->toString(), $this->followedProfile->getProfileId()->toString(), $this->VALID_FOLLOW_DATE);
        $follow->insert($this->getPDO());

        $numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
        self::assertEquals($numRows + 1, $numRowsAfterInsert);

        $pdoFollow = Follow::getFollowCountByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
        var_dump($pdoFollow);
//        self::assertEquals($this->profile->getProfileId(), $pdoFollow->getFollowProfileId());
//        self::assertEquals( $this->followedProfile->getProfileId(), $pdoFollow->getFollowFollowedProfileId());
//        self::assertEquals($pdoFollow->getFollowDate(), $this->VALID_FOLLOW_DATE);
    }

//    public function testGetValidFollows() : void {
//        $numRows = $this->getConnection()->getRowCount("follow");
//        $rowsInserted = 5;
//
//        for ($i=0; $i<$rowsInserted; $i++){
//            $followProfileId = generateUuidV4()->toString();
//            $follow = newFollow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID,
//                 $this->VALID_FOLLOW_PROFILE_ID,
//                 $this->VALID_FOLLOW_DATE);
//            $follow->insert($this->getPDO());
//        }
//
//        self::assertsEquals($numRows + $rowsInserted, $this->getConnection()->getRowCount("follow"));
//
//        self::assertsEquals($numRows + $rowsInserted, $follow->getAllFollows($this->getPDO())->count());
//    }


}
