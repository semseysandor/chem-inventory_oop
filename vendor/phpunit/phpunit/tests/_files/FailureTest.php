<?php declare(strict_types=1);
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
use PHPUnit\Framework\TestCase;

class FailureTest extends TestCase
{
    public function testAssertArrayEqualsArray(): void
    {
        $this->assertEquals([1], [2], 'message');
    }

    public function testAssertIntegerEqualsInteger(): void
    {
        $this->assertEquals(1, 2, 'message');
    }

    public function testAssertObjectEqualsObject(): void
    {
        $a      = new stdClass;
        $a->foo = 'bar';

        $b      = new stdClass;
        $b->bar = 'foo';

        $this->assertEquals($a, $b, 'message');
    }

    public function testAssertNullEqualsString(): void
    {
        $this->assertEquals(null, 'bar', 'message');
    }

    public function testAssertStringEqualsString(): void
    {
        $this->assertEquals('foo', 'bar', 'message');
    }

    public function testAssertTextEqualsText(): void
    {
        $this->assertEquals("foo\nbar\n", "foo\nbaz\n", 'message');
    }

    public function testAssertStringMatchesFormat(): void
    {
        $this->assertStringMatchesFormat('*%s*', '**', 'message');
    }

    public function testAssertNumericEqualsNumeric(): void
    {
        $this->assertEquals(1, 2, 'message');
    }

    public function testAssertTextSameText(): void
    {
        $this->assertSame('foo', 'bar', 'message');
    }

    public function testAssertObjectSameObject(): void
    {
        $this->assertSame(new stdClass, new stdClass, 'message');
    }

    public function testAssertObjectSameNull(): void
    {
        $this->assertSame(new stdClass, null, 'message');
    }

    public function testAssertFloatSameFloat(): void
    {
        $this->assertSame(1.0, 1.5, 'message');
    }

    // Note that due to the implementation of this assertion it counts as 2 asserts
    public function testAssertStringMatchesFormatFile(): void
    {
        $this->assertStringMatchesFormatFile(__DIR__ . '/expectedFileFormat.txt', '...BAR...');
    }
}
