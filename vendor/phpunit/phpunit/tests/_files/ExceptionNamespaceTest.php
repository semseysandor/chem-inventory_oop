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
namespace My\Space;

class ExceptionNamespaceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Exception message
     *
     * @var string
     */
    public const ERROR_MESSAGE = 'Exception namespace message';

    /**
     * Exception code
     *
     * @var int
     */
    public const ERROR_CODE = 200;

    /**
     * @expectedException Class
     * @expectedExceptionMessage My\Space\ExceptionNamespaceTest::ERROR_MESSAGE
     * @expectedExceptionCode My\Space\ExceptionNamespaceTest::ERROR_CODE
     */
    public function testConstants(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionCode My\Space\ExceptionNamespaceTest::UNKNOWN_CODE_CONSTANT
     * @expectedExceptionMessage My\Space\ExceptionNamespaceTest::UNKNOWN_MESSAGE_CONSTANT
     */
    public function testUnknownConstants(): void
    {
    }
}
