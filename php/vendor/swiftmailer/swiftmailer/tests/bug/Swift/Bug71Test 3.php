<?php

class Swift_Bug71Test extends \PHPUnit\Framework\TestCase
{
    private $message;

    protected function setUp()
    {
<<<<<<< HEAD
        $this->message = new Swift_Message('test');
=======
        $this->message = new Swift_Message('Test');
>>>>>>> profile-test
    }

    public function testCallingToStringAfterSettingNewBodyReflectsChanges()
    {
        $this->message->setBody('BODY1');
        $this->assertRegExp('/BODY1/', $this->message->toString());

        $this->message->setBody('BODY2');
        $this->assertRegExp('/BODY2/', $this->message->toString());
    }
}
