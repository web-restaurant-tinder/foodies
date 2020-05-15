<?php
namespace WebRestaurantTinder\Foodies\Test;

use WebRestaurantTinder\Foodies\Restaurant;
use WebRestaurantTinder\Foodies\Swipe;
use WebRestaurantTinder\Foodies\Profile;

require_once(dirname(__DIR__) . "/autoload.php");

require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

class SwipeTest extends DataDesignTest {

	private $profile;
	private $restaurant;
	private $VALID_SWIPE_DATE = null;
	private $VALID_SWIPE_RIGHT;
	private $VALID_HASH;
	private $VALID_ACTIVATION;


	public final function setUp(): void {
		parent::setUp();
		// create a salt and hash for the mocked profile
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 8]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		$this->profile = new Profile(generateUuidV4()->toString(), $this->VALID_ACTIVATION, "abhckb", "https://vsgdsd.com",
			"gfhd@gmail.com", "Jim",  $this->VALID_HASH, "Johnson", "gsdsda" );
		$this->profile->insert($this->getPDO());

		$this->restaurant = new Restaurant(generateUuidV4()->toString(), "4348 valley gardens", "starvh", "italian", "76",
			"70", "Olive", "505-567-7686", "5", "olive34.com");

		$this->restaurant->insert($this->getPDO());
		$this->VALID_SWIPE_DATE = new \DateTime();

		$this->VALID_SWIPE_RIGHT = 1;
	}

	public function testInsertValidSwipe() : void {
		$numRows = $this->getConnection()->getRowCount("swipe");
//        var_dump($this->profile->getProfileId()->toString(), $this->followedProfile->getProfileId()->toString());
		$swipe = new Swipe( $this->profile->getProfileId()->toString(),$this->restaurant->getRestaurantId()->toString(), $this->VALID_SWIPE_DATE, $this->VALID_SWIPE_RIGHT);
//     var_dump($this->restaurant->getRestaurantId()->toString());
//     var_dump($swipe->getSwipeRestaurantId());
		$swipe->insert($this->getPDO());
//        var_dump($follow);
		$numRowsAfterInsert = $this ->getConnection()->getRowCount("swipe");
		self::assertEquals($numRows + 1, $numRowsAfterInsert);

		$pdoSwipe = Swipe::getSwipeBySwipeProfileIdAndSwipeRestaurantId($this->getPDO(), $this->profile->getProfileId()->toString(), $this->restaurant->getRestaurantId()->toString());

		$this->assertEquals($this->profile->getProfileId()->toString(), $pdoSwipe->getSwipeProfileId()->toString());
		$this->assertEquals($this->restaurant->getRestaurantId(), $pdoSwipe->getSwipeRestaurantId());
		$this->assertEquals($this->VALID_SWIPE_DATE, $pdoSwipe->getSwipeDate());
		$this->assertEquals($this->VALID_SWIPE_RIGHT, $pdoSwipe->getSwipeRight());

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
////

	public function testDeleteValidSwipe() : void {
		//count number of rows
		$numRows = $this->getConnection()->getRowCount("swipe");
		$swipe = new Swipe($this->profile->getProfileId()->toString(), $this->restaurant->getRestaurantId()->toString(), $this->VALID_SWIPE_DATE, $this->VALID_SWIPE_RIGHT);
		$swipe->insert($this->getPDO());


		//delete the Follow from mySQl
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("swipe"));
		$swipe->delete($this->getPDO());

		$pdoSwipe = Swipe::getSwipeBySwipeProfileIdAndSwipeRestaurantId ($this->getPDO(), $swipe->getSwipeProfileId()->toString(), $swipe->getSwipeRestaurantId()->toString());
		$this->assertNull($pdoSwipe);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("swipe"));

	}

	public function testGetValidSwipeBySwipeProfileIdAndSwipeRestaurantId() : void {
		$numRows = $this->getConnection()->getRowCount("swipe");

		$swipe = new Swipe($this->profile->getProfileId()->toString(), $this->restaurant->getRestaurantId()->toString(), $this->VALID_SWIPE_DATE, $this->VALID_SWIPE_RIGHT);
		$swipe->insert($this->getPDO());

		$pdoSwipe = Swipe::getSwipeBySwipeProfileIdAndSwipeRestaurantId($this->getPDO(), $swipe->getSwipeProfileId()->toString(), $swipe->getSwipeRestaurantId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("swipe"));
		$this->assertEquals($this->profile->getProfileId()->toString(), $pdoSwipe->getSwipeProfileId()->toString());
		$this->assertEquals($this->restaurant->getRestaurantId(), $pdoSwipe->getSwipeRestaurantId());
		$this->assertEquals($this->VALID_SWIPE_DATE, $pdoSwipe->getSwipeDate());
		$this->assertEquals($this->VALID_SWIPE_RIGHT, $pdoSwipe->getSwipeRight());
	}


	public function testGetValidSwipeBySwipeProfileId() : void {
		$numRows = $this->getConnection()->getRowCount("swipe");

		$swipe = new Swipe($this->profile->getProfileId()->toString(), $this->restaurant->getRestaurantId()->toString(), $this->VALID_SWIPE_DATE, $this->VALID_SWIPE_RIGHT);
		$swipe->insert($this->getPDO());

		$results = Swipe::getSwipeBySwipeProfileId($this->getPDO(), $swipe->getSwipeProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("swipe"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("WebRestaurantTinder\\Foodies\\Swipe",$results);

		$pdoSwipe = $results[0];
		$this->assertEquals($this->profile->getProfileId()->toString(), $pdoSwipe->getSwipeProfileId()->toString());
		$this->assertEquals($this->restaurant->getRestaurantId(), $pdoSwipe->getSwipeRestaurantId());
		$this->assertEquals($this->VALID_SWIPE_DATE, $pdoSwipe->getSwipeDate());
		$this->assertEquals($this->VALID_SWIPE_RIGHT, $pdoSwipe->getSwipeRight());

	}


	public function testGetValidSwipeBySwipeRestaurantId() : void {
		$numRows = $this->getConnection()->getRowCount("swipe");

		$swipe = new Swipe($this->profile->getProfileId()->toString(), $this->restaurant->getRestaurantId()->toString(), $this->VALID_SWIPE_DATE, $this->VALID_SWIPE_RIGHT);
		$swipe->insert($this->getPDO());

		$results = Swipe::getSwipeBySwipeRestaurantId($this->getPDO(), $swipe->getSwipeRestaurantId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("swipe"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("WebRestaurantTinder\\Foodies\\Swipe",$results);

		$pdoSwipe = $results[0];
		$this->assertEquals($this->profile->getProfileId()->toString(), $pdoSwipe->getSwipeProfileId()->toString());
		$this->assertEquals($this->restaurant->getRestaurantId(), $pdoSwipe->getSwipeRestaurantId());
		$this->assertEquals($this->VALID_SWIPE_DATE, $pdoSwipe->getSwipeDate());
		$this->assertEquals($this->VALID_SWIPE_RIGHT, $pdoSwipe->getSwipeRight());
	}
//
//
//	public function testGetValidFollowCountByFollowFollowedProfileId() : void {
//		$numRows = $this->getConnection()->getRowCount("follow");
//
//		$follow = new Follow($this->profile->getProfileId()->toString(), $this->followedProfile->getProfileId()->toString(), $this->VALID_FOLLOW_DATE);
//		$follow->insert($this->getPDO());
//
//		$numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
//		self::assertEquals($numRows + 1, $numRowsAfterInsert);
//
//		$pdoFollow = Follow::getFollowCountByFollowFollowedProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
////        var_dump($pdoFollow);
////        self::assertEquals($this->profile->getProfileId(), $pdoFollow->getFollowProfileId());
////        self::assertEquals( $this->followedProfile->getProfileId(), $pdoFollow->getFollowFollowedProfileId());
////        self::assertEquals($pdoFollow->getFollowDate(), $this->VALID_FOLLOW_DATE);
//	}
//
//	public function testGetValidFollowCountByFollowProfileId() : void {
//		$numRows = $this->getConnection()->getRowCount("follow");
//
//		$follow = new Follow($this->profile->getProfileId()->toString(), $this->followedProfile->getProfileId()->toString(), $this->VALID_FOLLOW_DATE);
//		$follow->insert($this->getPDO());
//
//		$numRowsAfterInsert = $this->getConnection()->getRowCount("follow");
//		self::assertEquals($numRows + 1, $numRowsAfterInsert);
//
//		$pdoFollow = Follow::getFollowCountByFollowProfileId($this->getPDO(), $follow->getFollowProfileId()->toString());
////        var_dump($pdoFollow);
////        self::assertEquals($this->profile->getProfileId(), $pdoFollow->getFollowProfileId());
////        self::assertEquals( $this->followedProfile->getProfileId(), $pdoFollow->getFollowFollowedProfileId());
////        self::assertEquals($pdoFollow->getFollowDate(), $this->VALID_FOLLOW_DATE);
//	}
//
////    public function testGetValidFollows() : void {
////        $numRows = $this->getConnection()->getRowCount("follow");
////        $rowsInserted = 5;
////
////        for ($i=0; $i<$rowsInserted; $i++){
////            $followProfileId = generateUuidV4()->toString();
////            $follow = newFollow($followProfileId, $this->VALID_FOLLOW_FOLLOWED_PROFILE_ID,
////                 $this->VALID_FOLLOW_PROFILE_ID,
////                 $this->VALID_FOLLOW_DATE);
////            $follow->insert($this->getPDO());
////        }
////
////        self::assertsEquals($numRows + $rowsInserted, $this->getConnection()->getRowCount("follow"));
////
////        self::assertsEquals($numRows + $rowsInserted, $follow->getAllFollows($this->getPDO())->count());
////    }
//

}