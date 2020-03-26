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
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;

final class MyTestListener implements TestListener
{
    private $endCount = 0;

    private $errorCount = 0;

    private $failureCount = 0;

    private $warningCount = 0;

    private $notImplementedCount = 0;

    private $riskyCount = 0;

    private $skippedCount = 0;

    private $startCount = 0;

    public function addError(Test $test, \Throwable $t, float $time): void
    {
        $this->errorCount++;
    }

    public function addWarning(Test $test, Warning $e, float $time): void
    {
        $this->warningCount++;
    }

    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
        $this->failureCount++;
    }

    public function addIncompleteTest(Test $test, \Throwable $t, float $time): void
    {
        $this->notImplementedCount++;
    }

    public function addRiskyTest(Test $test, \Throwable $t, float $time): void
    {
        $this->riskyCount++;
    }

    public function addSkippedTest(Test $test, \Throwable $t, float $time): void
    {
        $this->skippedCount++;
    }

    public function startTestSuite(TestSuite $suite): void
    {
    }

    public function endTestSuite(TestSuite $suite): void
    {
    }

    public function startTest(Test $test): void
    {
        $this->startCount++;
    }

    public function endTest(Test $test, float $time): void
    {
        $this->endCount++;
    }

    public function endCount(): int
    {
        return $this->endCount;
    }

    public function errorCount(): int
    {
        return $this->errorCount;
    }

    public function failureCount(): int
    {
        return $this->failureCount;
    }

    public function warningCount(): int
    {
        return $this->warningCount;
    }

    public function notImplementedCount(): int
    {
        return $this->notImplementedCount;
    }

    public function riskyCount(): int
    {
        return $this->riskyCount;
    }

    public function skippedCount(): int
    {
        return $this->skippedCount;
    }

    public function startCount(): int
    {
        return $this->startCount;
    }
}
