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

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState enabled
 */
class Issue1335Test extends TestCase
{
    public function testGlobalString(): void
    {
        $this->assertEquals('Hello', $GLOBALS['globalString']);
    }

    public function testGlobalIntTruthy(): void
    {
        $this->assertEquals(1, $GLOBALS['globalIntTruthy']);
    }

    public function testGlobalIntFalsey(): void
    {
        $this->assertEquals(0, $GLOBALS['globalIntFalsey']);
    }

    public function testGlobalFloat(): void
    {
        $this->assertEquals(1.123, $GLOBALS['globalFloat']);
    }

    public function testGlobalBoolTrue(): void
    {
        $this->assertTrue($GLOBALS['globalBoolTrue']);
    }

    public function testGlobalBoolFalse(): void
    {
        $this->assertFalse($GLOBALS['globalBoolFalse']);
    }

    public function testGlobalNull(): void
    {
        $this->assertEquals(null, $GLOBALS['globalNull']);
    }

    public function testGlobalArray(): void
    {
        $this->assertEquals(['foo'], $GLOBALS['globalArray']);
    }

    public function testGlobalNestedArray(): void
    {
        $this->assertEquals([['foo']], $GLOBALS['globalNestedArray']);
    }

    public function testGlobalObject(): void
    {
        $this->assertEquals((object) ['foo'=> 'bar'], $GLOBALS['globalObject']);
    }

    public function testGlobalObjectWithBackSlashString(): void
    {
        $this->assertEquals((object) ['foo'=> 'back\\slash'], $GLOBALS['globalObjectWithBackSlashString']);
    }

    public function testGlobalObjectWithDoubleBackSlashString(): void
    {
        $this->assertEquals((object) ['foo'=> 'back\\\\slash'], $GLOBALS['globalObjectWithDoubleBackSlashString']);
    }
}
