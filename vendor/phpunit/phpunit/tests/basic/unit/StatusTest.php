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
namespace PHPUnit\SelfTest\Basic;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Warning;

/**
 * @covers Foo
 *
 * @uses Bar
 *
 * @testdox Test result status with and without message
 */
class StatusTest extends TestCase
{
    public function testSuccess(): void
    {
        $this->createMock(\AnInterface::class);

        $this->assertTrue(true);
    }

    public function testFailure(): void
    {
        $this->assertTrue(false);
    }

    public function testError(): void
    {
        throw new \RuntimeException;
    }

    public function testIncomplete(): void
    {
        $this->markTestIncomplete();
    }

    public function testSkipped(): void
    {
        $this->markTestSkipped();
    }

    public function testRisky(): void
    {
    }

    public function testWarning(): void
    {
        throw new Warning;
    }

    public function testSuccessWithMessage(): void
    {
        $this->assertTrue(true, '"success with custom message"');
    }

    public function testFailureWithMessage(): void
    {
        $this->assertTrue(false, 'failure with custom message');
    }

    public function testErrorWithMessage(): void
    {
        throw new \RuntimeException('error with custom message');
    }

    public function testIncompleteWithMessage(): void
    {
        $this->markTestIncomplete('incomplete with custom message');
    }

    public function testSkippedWithMessage(): void
    {
        $this->markTestSkipped('skipped with custom message');
    }

    public function testRiskyWithMessage(): void
    {
        // Custom messages not implemented for risky status
    }

    public function testWarningWithMessage(): void
    {
        throw new Warning('warning with custom message');
    }
}
