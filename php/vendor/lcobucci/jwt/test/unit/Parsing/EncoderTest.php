<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Lcobucci\JWT\Parsing;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 0.1.0
 */
class EncoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @Test
     *
     * @covers Lcobucci\JWT\Parsing\Encoder::jsonEncode
     */
    public function jsonEncodeMustReturnAJSONString()
    {
        $encoder = new Encoder();

        $this->assertEquals('{"Test":"Test"}', $encoder->jsonEncode(['Test' => 'Test']));
    }

    /**
     * @Test
     *
     * @covers Lcobucci\JWT\Parsing\Encoder::jsonEncode
     *
     * @expectedException \RuntimeException
     */
    public function jsonEncodeMustRaiseExceptionWhenAnErrorHasOccured()
    {
        $encoder = new Encoder();
        $encoder->jsonEncode("\xB1\x31");
    }

    /**
     * @Test
     *
     * @covers Lcobucci\JWT\Parsing\Encoder::base64UrlEncode
     */
    public function base64UrlEncodeMustReturnAnUrlSafeBase64()
    {
        $data = base64_decode('0MB2wKB+L3yvIdzeggmJ+5WOSLaRLTUPXbpzqUe0yuo=');

        $encoder = new Encoder();
        $this->assertEquals('0MB2wKB-L3yvIdzeggmJ-5WOSLaRLTUPXbpzqUe0yuo', $encoder->base64UrlEncode($data));
    }
}
