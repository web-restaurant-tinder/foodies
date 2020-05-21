<?php declare(strict_types=1);
/*
 * This file is part of sebastian/diff.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianBergmann\Diff;

use PHPUnit\Framework\TestCase;

/**
 * @covers SebastianBergmann\Diff\ConfigurationException
 */
final class ConfigurationExceptionTest extends TestCase
{
    public function testConstructWithDefaults(): void
    {
<<<<<<< HEAD
        $e = new ConfigurationException('test', 'A', 'B');

        $this->assertSame(0, $e->getCode());
        $this->assertNull($e->getPrevious());
        $this->assertSame('Option "test" must be A, got "string#B".', $e->getMessage());
=======
        $e = new ConfigurationException('Test', 'A', 'B');

        $this->assertSame(0, $e->getCode());
        $this->assertNull($e->getPrevious());
        $this->assertSame('Option "Test" must be A, got "string#B".', $e->getMessage());
>>>>>>> profile-test
    }

    public function testConstruct(): void
    {
        $e = new ConfigurationException(
<<<<<<< HEAD
            'test',
=======
            'Test',
>>>>>>> profile-test
            'integer',
            new \SplFileInfo(__FILE__),
            789,
            new \BadMethodCallException(__METHOD__)
        );

<<<<<<< HEAD
        $this->assertSame('Option "test" must be integer, got "SplFileInfo".', $e->getMessage());
=======
        $this->assertSame('Option "Test" must be integer, got "SplFileInfo".', $e->getMessage());
>>>>>>> profile-test
    }
}
