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
namespace PHPUnit\Util\TestDox;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Color;

/**
 * @group testdox
 * @small
 */
final class CliTestDoxPrinterColorTest extends TestCase
{
    /**
     * @var TestableCliTestDoxPrinter
     */
    private $printer;

    protected function setUp(): void
    {
        $this->printer        = new TestableCliTestDoxPrinter(null, true, \PHPUnit\TextUI\ResultPrinter::COLOR_ALWAYS);
    }

    protected function tearDown(): void
    {
        $this->printer        = null;
    }

    public function testColorizesDiffInFailureMessage(): void
    {
        $raw     = \implode(\PHP_EOL, ['some message', '--- Expected', '+++ Actual', '@@ @@']);
        $failure = new AssertionFailedError($raw);

        $this->printer->startTest($this);
        $this->printer->addFailure($this, $failure, 0);
        $this->printer->endTest($this, 0.001);

        $this->assertStringContainsString(Color::colorize('bg-red,fg-white', 'some message'), $this->printer->getBuffer());
        $this->assertStringContainsString(Color::colorize('fg-red', '---' . Color::dim('·') . 'Expected'), $this->printer->getBuffer());
        $this->assertStringContainsString(Color::colorize('fg-green', '+++' . Color::dim('·') . 'Actual'), $this->printer->getBuffer());
        $this->assertStringContainsString(Color::colorize('fg-cyan', '@@ @@'), $this->printer->getBuffer());
    }
}
