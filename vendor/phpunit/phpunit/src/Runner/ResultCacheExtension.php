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
namespace PHPUnit\Runner;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class ResultCacheExtension implements AfterIncompleteTestHook, AfterLastTestHook, AfterRiskyTestHook, AfterSkippedTestHook, AfterSuccessfulTestHook, AfterTestErrorHook, AfterTestFailureHook, AfterTestWarningHook
{
    /**
     * @var TestResultCache
     */
    private $cache;

    public function __construct(TestResultCache $cache)
    {
        $this->cache = $cache;
    }

    public function flush(): void
    {
        $this->cache->persist();
    }

    public function executeAfterSuccessfulTest(string $test, float $time): void
    {
        $testName = $this->getTestName($test);

        $this->cache->setTime($testName, \round($time, 3));
    }

    public function executeAfterIncompleteTest(string $test, string $message, float $time): void
    {
        $testName = $this->getTestName($test);

        $this->cache->setTime($testName, \round($time, 3));
        $this->cache->setState($testName, BaseTestRunner::STATUS_INCOMPLETE);
    }

    public function executeAfterRiskyTest(string $test, string $message, float $time): void
    {
        $testName = $this->getTestName($test);

        $this->cache->setTime($testName, \round($time, 3));
        $this->cache->setState($testName, BaseTestRunner::STATUS_RISKY);
    }

    public function executeAfterSkippedTest(string $test, string $message, float $time): void
    {
        $testName = $this->getTestName($test);

        $this->cache->setTime($testName, \round($time, 3));
        $this->cache->setState($testName, BaseTestRunner::STATUS_SKIPPED);
    }

    public function executeAfterTestError(string $test, string $message, float $time): void
    {
        $testName = $this->getTestName($test);

        $this->cache->setTime($testName, \round($time, 3));
        $this->cache->setState($testName, BaseTestRunner::STATUS_ERROR);
    }

    public function executeAfterTestFailure(string $test, string $message, float $time): void
    {
        $testName = $this->getTestName($test);

        $this->cache->setTime($testName, \round($time, 3));
        $this->cache->setState($testName, BaseTestRunner::STATUS_FAILURE);
    }

    public function executeAfterTestWarning(string $test, string $message, float $time): void
    {
        $testName = $this->getTestName($test);

        $this->cache->setTime($testName, \round($time, 3));
        $this->cache->setState($testName, BaseTestRunner::STATUS_WARNING);
    }

    public function executeAfterLastTest(): void
    {
        $this->flush();
    }

    /**
     * @param string $test A long description format of the current test
     *
     * @return string The test name without TestSuiteClassName:: and @dataprovider details
     */
    private function getTestName(string $test): string
    {
        $matches = [];

        if (\preg_match('/^(?<name>\S+::\S+)(?:(?<dataname> with data set (?:#\d+|"[^"]+"))\s\()?/', $test, $matches)) {
            $test = $matches['name'] . ($matches['dataname'] ?? '');
        }

        return $test;
    }
}
