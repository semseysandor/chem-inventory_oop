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

class ExceptionTest extends TestCase
{
    /**
     * Exception message
     *
     * @var string
     */
    public const ERROR_MESSAGE = 'Exception message';

    /**
     * Exception message
     *
     * @var string
     */
    public const ERROR_MESSAGE_REGEX = '#regex#';

    /**
     * Exception code
     *
     * @var int
     */
    public const ERROR_CODE = 500;

    /**
     * @expectedException FooBarBaz
     */
    public function testOne(): void
    {
    }

    /**
     * @expectedException Foo_Bar_Baz
     */
    public function testTwo(): void
    {
    }

    /**
     * @expectedException Foo\Bar\Baz
     */
    public function testThree(): void
    {
    }

    /**
     * @expectedException ほげ
     */
    public function testFour(): void
    {
    }

    /**
     * @expectedException Class Message 1234
     */
    public function testFive(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionMessage Message
     * @expectedExceptionCode 1234
     */
    public function testSix(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionMessage Message
     * @expectedExceptionCode ExceptionCode
     */
    public function testSeven(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionMessage Message
     * @expectedExceptionCode 0
     */
    public function testEight(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionMessage ExceptionTest::ERROR_MESSAGE
     * @expectedExceptionCode ExceptionTest::ERROR_CODE
     */
    public function testNine(): void
    {
    }

    /** @expectedException Class */
    public function testSingleLine(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionCode ExceptionTest::UNKNOWN_CODE_CONSTANT
     * @expectedExceptionMessage ExceptionTest::UNKNOWN_MESSAGE_CONSTANT
     */
    public function testUnknownConstants(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionCode 1234
     * @expectedExceptionMessage Message
     * @expectedExceptionMessageRegExp #regex#
     */
    public function testWithRegexMessage(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionCode 1234
     * @expectedExceptionMessage Message
     * @expectedExceptionMessageRegExp ExceptionTest::ERROR_MESSAGE_REGEX
     */
    public function testWithRegexMessageFromClassConstant(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionCode 1234
     * @expectedExceptionMessage Message
     * @expectedExceptionMessageRegExp ExceptionTest::UNKNOWN_MESSAGE_REGEX_CONSTANT
     */
    public function testWithUnknowRegexMessageFromClassConstant(): void
    {
    }
}
