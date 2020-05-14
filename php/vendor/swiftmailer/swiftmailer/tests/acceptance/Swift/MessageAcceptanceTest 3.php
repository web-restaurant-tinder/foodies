<?php

require_once 'swift_required.php';
require_once __DIR__.'/Mime/SimpleMessageAcceptanceTest.php';

class Swift_MessageAcceptanceTest extends Swift_Mime_SimpleMessageAcceptanceTest
{
    public function testAddPartWrapper()
    {
        $message = $this->createMessage();
<<<<<<< HEAD
        $message->setSubject('just a test subject');
=======
        $message->setSubject('just a Test subject');
>>>>>>> profile-test
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);

        $id = $message->getId();
        $date = $message->getDate();
        $boundary = $message->getBoundary();

        $message->addPart('foo', 'text/plain', 'iso-8859-1');
<<<<<<< HEAD
        $message->addPart('test <b>foo</b>', 'text/html', 'iso-8859-1');
=======
        $message->addPart('Test <b>foo</b>', 'text/html', 'iso-8859-1');
>>>>>>> profile-test

        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
<<<<<<< HEAD
            'Subject: just a test subject'."\r\n".
=======
            'Subject: just a Test subject'."\r\n".
>>>>>>> profile-test
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: multipart/alternative;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'Content-Type: text/plain; charset=iso-8859-1'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foo'.
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'Content-Type: text/html; charset=iso-8859-1'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
<<<<<<< HEAD
            'test <b>foo</b>'.
=======
            'Test <b>foo</b>'.
>>>>>>> profile-test
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n",
            $message->toString()
            );
    }

    protected function createMessage()
    {
        Swift_DependencyContainer::getInstance()
            ->register('properties.charset')->asValue(null);

        return new Swift_Message();
    }
}