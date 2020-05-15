<?php declare(strict_types=1);
/*
 * This file is part of sebastian/environment.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\Environment;

use PHPUnit\Framework\TestCase;

/**
 * @covers \SebastianBergmann\Environment\Console
 */
final class ConsoleTest extends TestCase
{
    /**
     * @var \SebastianBergmann\Environment\Console
     */
    private $console;

    protected function setUp(): void
    {
        $this->console = new Console;
    }

    /**
     * @todo Now that this component is PHP 7-only and uses return type declarations
<<<<<<< HEAD
     * this test makes even less sense than before
=======
     * this Test makes even less sense than before
>>>>>>> profile-test
     */
    public function testCanDetectIfStdoutIsInteractiveByDefault(): void
    {
        $this->assertIsBool($this->console->isInteractive());
    }

    /**
     * @todo Now that this component is PHP 7-only and uses return type declarations
<<<<<<< HEAD
     * this test makes even less sense than before
=======
     * this Test makes even less sense than before
>>>>>>> profile-test
     */
    public function testCanDetectIfFileDescriptorIsInteractive(): void
    {
        $this->assertIsBool($this->console->isInteractive(\STDOUT));
    }

    /**
     * @todo Now that this component is PHP 7-only and uses return type declarations
<<<<<<< HEAD
     * this test makes even less sense than before
=======
     * this Test makes even less sense than before
>>>>>>> profile-test
     */
    public function testCanDetectColorSupport(): void
    {
        $this->assertIsBool($this->console->hasColorSupport());
    }

    /**
     * @todo Now that this component is PHP 7-only and uses return type declarations
<<<<<<< HEAD
     * this test makes even less sense than before
=======
     * this Test makes even less sense than before
>>>>>>> profile-test
     */
    public function testCanDetectNumberOfColumns(): void
    {
        $this->assertIsInt($this->console->getNumberOfColumns());
    }
}
