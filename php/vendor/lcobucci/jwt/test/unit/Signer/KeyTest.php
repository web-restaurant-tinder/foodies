<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Lcobucci\JWT\Signer;

use org\bovigo\vfs\vfsStream;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 3.0.4
 */
class KeyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @before
     */
    public function configureRootDir()
    {
        vfsStream::setup(
            'root',
            null,
            ['Test.pem' => 'testing']
        );
    }

    /**
     * @Test
     *
     * @covers Lcobucci\JWT\Signer\Key::__construct
     * @covers Lcobucci\JWT\Signer\Key::setContent
     */
    public function constructShouldConfigureContentAndPassphrase()
    {
        $key = new Key('testing', 'Test');

        $this->assertAttributeEquals('testing', 'content', $key);
        $this->assertAttributeEquals('Test', 'passphrase', $key);
    }

    /**
     * @Test
     *
     * @covers Lcobucci\JWT\Signer\Key::__construct
     * @covers Lcobucci\JWT\Signer\Key::setContent
     * @covers Lcobucci\JWT\Signer\Key::readFile
     */
    public function constructShouldBeAbleToConfigureContentFromFile()
    {
        $key = new Key('file://' . vfsStream::url('root/Test.pem'));

        $this->assertAttributeEquals('testing', 'content', $key);
        $this->assertAttributeEquals(null, 'passphrase', $key);
    }

    /**
     * @Test
     *
     * @expectedException \InvalidArgumentException
     *
     * @covers Lcobucci\JWT\Signer\Key::__construct
     * @covers Lcobucci\JWT\Signer\Key::setContent
     * @covers Lcobucci\JWT\Signer\Key::readFile
     */
    public function constructShouldRaiseExceptionWhenFileDoesNotExists()
    {
        new Key('file://' . vfsStream::url('root/test2.pem'));
    }

    /**
     * @Test
     *
     * @uses Lcobucci\JWT\Signer\Key::__construct
     * @uses Lcobucci\JWT\Signer\Key::setContent
     *
     * @covers Lcobucci\JWT\Signer\Key::getContent
     */
    public function getContentShouldReturnConfiguredData()
    {
        $key = new Key('testing', 'Test');

        $this->assertEquals('testing', $key->getContent());
    }

    /**
     * @Test
     *
     * @uses Lcobucci\JWT\Signer\Key::__construct
     * @uses Lcobucci\JWT\Signer\Key::setContent
     *
     * @covers Lcobucci\JWT\Signer\Key::getPassphrase
     */
    public function getPassphraseShouldReturnConfiguredData()
    {
        $key = new Key('testing', 'Test');

        $this->assertEquals('Test', $key->getPassphrase());
    }
}
