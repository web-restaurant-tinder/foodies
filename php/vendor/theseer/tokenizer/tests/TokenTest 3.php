<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase {

    /** @var  Token */
    private $token;

    protected function setUp() {
<<<<<<< HEAD
        $this->token = new Token(1,'test-dummy', 'blank');
=======
        $this->token = new Token(1,'Test-dummy', 'blank');
>>>>>>> profile-test
    }

    public function testTokenCanBeCreated() {
        $this->assertInstanceOf(Token::class, $this->token);
    }

    public function testTokenLineCanBeRetrieved() {
        $this->assertEquals(1, $this->token->getLine());
    }

    public function testTokenNameCanBeRetrieved() {
<<<<<<< HEAD
        $this->assertEquals('test-dummy', $this->token->getName());
=======
        $this->assertEquals('Test-dummy', $this->token->getName());
>>>>>>> profile-test
    }

    public function testTokenValueCanBeRetrieved() {
        $this->assertEquals('blank', $this->token->getValue());
    }

}
