<?php

/**
 * @group smoke
 */
class Swift_Smoke_InternationalSmokeTest extends SwiftMailerSmokeTestCase
{
    private $_attFile;

    protected function setUp()
    {
        parent::setUp(); // For skip
        $this->attFile = __DIR__.'/../../../_samples/files/textfile.zip';
    }

    public function testAttachmentSending()
    {
        $mailer = $this->getMailer();
        $message = (new Swift_Message())
            ->setCharset('utf-8')
            ->setSubject('[Swift Mailer] InternationalSmokeTest (διεθνής)')
            ->setFrom([SWIFT_SMOKE_EMAIL_ADDRESS => 'Χριστοφορου (Swift Mailer)'])
            ->setTo(SWIFT_SMOKE_EMAIL_ADDRESS)
            ->setBody('This message should contain an attached ZIP file (named "κείμενο, εδάφιο, θέμα.zip").'.PHP_EOL.
                'When unzipped, the archive should produce a text file which reads:'.PHP_EOL.
<<<<<<< HEAD
                '"This is part of a Swift Mailer smoke test."'.PHP_EOL.
=======
                '"This is part of a Swift Mailer smoke Test."'.PHP_EOL.
>>>>>>> profile-test
                PHP_EOL.
                'Following is some arbitrary Greek text:'.PHP_EOL.
                'Δεν βρέθηκαν λέξεις.'
                )
            ->attach(Swift_Attachment::fromPath($this->attFile)
                ->setContentType('application/zip')
                ->setFilename('κείμενο, εδάφιο, θέμα.zip')
                )
            ;
        $this->assertEquals(1, $mailer->send($message),
<<<<<<< HEAD
            '%s: The smoke test should send a single message'
=======
            '%s: The smoke Test should send a single message'
>>>>>>> profile-test
            );
    }
}
