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
namespace PHPUnit\Test;

use PHPUnit\Runner\AfterIncompleteTestHook;
use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterRiskyTestHook;
use PHPUnit\Runner\AfterSkippedTestHook;
use PHPUnit\Runner\AfterSuccessfulTestHook;
use PHPUnit\Runner\AfterTestErrorHook;
use PHPUnit\Runner\AfterTestFailureHook;
use PHPUnit\Runner\AfterTestHook;
use PHPUnit\Runner\AfterTestWarningHook;
use PHPUnit\Runner\BeforeFirstTestHook;
use PHPUnit\Runner\BeforeTestHook;

final class Extension implements AfterIncompleteTestHook, AfterLastTestHook, AfterRiskyTestHook, AfterSkippedTestHook, AfterSuccessfulTestHook, AfterTestErrorHook, AfterTestFailureHook, AfterTestHook, AfterTestWarningHook, BeforeFirstTestHook, BeforeTestHook
{
    private $amountOfInjectedArguments = 0;

    public function __construct()
    {
        $this->amountOfInjectedArguments = \count(\func_get_args());
    }

    public function tellAmountOfInjectedArguments(): void
    {
        print __METHOD__ . ': ' . $this->amountOfInjectedArguments . \PHP_EOL;
    }

    public function executeBeforeFirstTest(): void
    {
        $this->tellAmountOfInjectedArguments();
        print __METHOD__ . \PHP_EOL;
    }

    public function executeBeforeTest(string $test): void
    {
        print __METHOD__ . ': ' . $test . \PHP_EOL;
    }

    public function executeAfterTest(string $test, float $time): void
    {
        print __METHOD__ . ': ' . $test . \PHP_EOL;
    }

    public function executeAfterSuccessfulTest(string $test, float $time): void
    {
        print __METHOD__ . ': ' . $test . \PHP_EOL;
    }

    public function executeAfterIncompleteTest(string $test, string $message, float $time): void
    {
        print __METHOD__ . ': ' . $test . ': ' . $message . \PHP_EOL;
    }

    public function executeAfterRiskyTest(string $test, string $message, float $time): void
    {
        print __METHOD__ . ': ' . $test . ': ' . $message . \PHP_EOL;
    }

    public function executeAfterSkippedTest(string $test, string $message, float $time): void
    {
        print __METHOD__ . ': ' . $test . ': ' . $message . \PHP_EOL;
    }

    public function executeAfterTestError(string $test, string $message, float $time): void
    {
        print __METHOD__ . ': ' . $test . ': ' . $message . \PHP_EOL;
    }

    public function executeAfterTestFailure(string $test, string $message, float $time): void
    {
        print __METHOD__ . ': ' . $test . ': ' . $message . \PHP_EOL;
    }

    public function executeAfterTestWarning(string $test, string $message, float $time): void
    {
        print __METHOD__ . ': ' . $test . ': ' . $message . \PHP_EOL;
    }

    public function executeAfterLastTest(): void
    {
        print __METHOD__ . \PHP_EOL;
    }
}
