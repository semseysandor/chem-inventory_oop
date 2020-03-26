<?php declare(strict_types = 1);
/**
 +---------------------------------------------------------------------+
 | This file is part of chem-inventory.                                |
 |                                                                     |
 | Copyright (c) 2020 Sandor Semsey                                    |
 | All rights reserved.                                                |
 |                                                                     |
 | This work is published under the MIT License.                       |
 | https://choosealicense.com/licenses/mit/                            |
 |                                                                     |
 | It's a free software;)                                              |
 |                                                                     |
 | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 | SOFTWARE.                                                           |
 +---------------------------------------------------------------------+
 */

namespace TheSeer\Tokenizer;

use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase {

    /** @var  Token */
    private $token;

    protected function setUp() {
        $this->token = new Token(1,'test-dummy', 'blank');
    }

    public function testTokenCanBeCreated() {
        $this->assertInstanceOf(Token::class, $this->token);
    }

    public function testTokenLineCanBeRetrieved() {
        $this->assertEquals(1, $this->token->getLine());
    }

    public function testTokenNameCanBeRetrieved() {
        $this->assertEquals('test-dummy', $this->token->getName());
    }

    public function testTokenValueCanBeRetrieved() {
        $this->assertEquals('blank', $this->token->getValue());
    }

}
