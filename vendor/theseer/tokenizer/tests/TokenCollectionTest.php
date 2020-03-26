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

/**
 * @covers \TheSeer\Tokenizer\TokenCollection
 */
class TokenCollectionTest extends TestCase {

    /** @var  TokenCollection */
    private $collection;

    protected function setUp() {
        $this->collection = new TokenCollection();
    }

    public function testCollectionIsInitiallyEmpty() {
        $this->assertCount(0, $this->collection);
    }

    public function testTokenCanBeAddedToCollection() {
        $token = $this->createMock(Token::class);
        $this->collection->addToken($token);

        $this->assertCount(1, $this->collection);
        $this->assertSame($token, $this->collection[0]);
    }

    public function testCanIterateOverTokens() {
        $token = $this->createMock(Token::class);
        $this->collection->addToken($token);
        $this->collection->addToken($token);

        foreach($this->collection as $position => $current) {
            $this->assertInternalType('integer', $position);
            $this->assertSame($token, $current);
        }
    }

    public function testOffsetCanBeUnset() {
        $token = $this->createMock(Token::class);
        $this->collection->addToken($token);

        $this->assertCount(1, $this->collection);
        unset($this->collection[0]);
        $this->assertCount(0, $this->collection);
    }

    public function testTokenCanBeSetViaOffsetPosition() {
        $token = $this->createMock(Token::class);
        $this->collection[0] = $token;
        $this->assertCount(1, $this->collection);
        $this->assertSame($token, $this->collection[0]);
    }

    public function testTryingToUseNonIntegerOffsetThrowsException() {
        $this->expectException(TokenCollectionException::class);
        $this->collection['foo'] = $this->createMock(Token::class);
    }

    public function testTryingToSetNonTokenAtOffsetThrowsException() {
        $this->expectException(TokenCollectionException::class);
        $this->collection[0] = 'abc';
    }

    public function testTryingToGetTokenAtNonExistingOffsetThrowsException() {
        $this->expectException(TokenCollectionException::class);
        $x = $this->collection[3];
    }

}
