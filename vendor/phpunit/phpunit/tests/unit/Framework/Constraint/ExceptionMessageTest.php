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
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\TestCase;

/**
 * @small
 */
final class ExceptionMessageTest extends TestCase
{
    public function testLiteralMessage(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('A literal exception message');

        throw new \Exception('A literal exception message');
    }

    public function testPartialMessageBegin(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('A partial');

        throw new \Exception('A partial exception message');
    }

    public function testPartialMessageMiddle(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('partial exception');

        throw new \Exception('A partial exception message');
    }

    public function testPartialMessageEnd(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('exception message');

        throw new \Exception('A partial exception message');
    }

    public function testEmptyMessageExportToString(): void
    {
        $exceptionMessage = new ExceptionMessage('');

        $this->assertSame('exception message is empty', $exceptionMessage->toString());
    }

    public function testMessageExportToString(): void
    {
        $exceptionMessage = new ExceptionMessage('test');

        $this->assertSame('exception message contains ', $exceptionMessage->toString());
    }
}
