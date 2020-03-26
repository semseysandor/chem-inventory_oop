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
namespace PHPUnit\Framework;

/**
 * @deprecated Use the `TestHook` interfaces instead
 */
interface TestListener
{
    /**
     * An error occurred.
     *
     * @deprecated Use `AfterTestErrorHook::executeAfterTestError` instead
     */
    public function addError(Test $test, \Throwable $t, float $time): void;

    /**
     * A warning occurred.
     *
     * @deprecated Use `AfterTestWarningHook::executeAfterTestWarning` instead
     */
    public function addWarning(Test $test, Warning $e, float $time): void;

    /**
     * A failure occurred.
     *
     * @deprecated Use `AfterTestFailureHook::executeAfterTestFailure` instead
     */
    public function addFailure(Test $test, AssertionFailedError $e, float $time): void;

    /**
     * Incomplete test.
     *
     * @deprecated Use `AfterIncompleteTestHook::executeAfterIncompleteTest` instead
     */
    public function addIncompleteTest(Test $test, \Throwable $t, float $time): void;

    /**
     * Risky test.
     *
     * @deprecated Use `AfterRiskyTestHook::executeAfterRiskyTest` instead
     */
    public function addRiskyTest(Test $test, \Throwable $t, float $time): void;

    /**
     * Skipped test.
     *
     * @deprecated Use `AfterSkippedTestHook::executeAfterSkippedTest` instead
     */
    public function addSkippedTest(Test $test, \Throwable $t, float $time): void;

    /**
     * A test suite started.
     */
    public function startTestSuite(TestSuite $suite): void;

    /**
     * A test suite ended.
     */
    public function endTestSuite(TestSuite $suite): void;

    /**
     * A test started.
     *
     * @deprecated Use `BeforeTestHook::executeBeforeTest` instead
     */
    public function startTest(Test $test): void;

    /**
     * A test ended.
     *
     * @deprecated Use `AfterTestHook::executeAfterTest` instead
     */
    public function endTest(Test $test, float $time): void;
}
