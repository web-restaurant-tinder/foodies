<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit\Framework\TestCase;

class DataProviderFilterTest extends TestCase
{
    public static function truthProvider()
    {
        return [
            [true],
            [true],
            [true],
            [true],
        ];
    }

    public static function falseProvider()
    {
        return [
            'false Test'       => [false],
            'false Test 2'     => [false],
            'other false Test' => [false],
            'other false test2'=> [false],
        ];
    }

    /**
     * @dataProvider truthProvider
     */
    public function testTrue($truth): void
    {
        $this->assertTrue($truth);
    }

    /**
     * @dataProvider falseProvider
     */
    public function testFalse($false): void
    {
        $this->assertFalse($false);
    }
}
