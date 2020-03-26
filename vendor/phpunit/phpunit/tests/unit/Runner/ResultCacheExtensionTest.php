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

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestCaseTest;
use PHPUnit\Framework\TestResult;
use PHPUnit\Framework\TestSuite;

/**
 * @group test-reorder
 * @small
 */
final class ResultCacheExtensionTest extends TestCase
{
    /**
     * @var DefaultTestResultCache
     */
    protected $cache;

    /**
     * @var ResultCacheExtension
     */
    protected $extension;

    /**
     * @var TestResult
     */
    protected $result;

    protected function setUp(): void
    {
        $this->cache     = new DefaultTestResultCache;
        $this->extension = new ResultCacheExtension($this->cache);

        $listener = new TestListenerAdapter;
        $listener->add($this->extension);

        $this->result   = new TestResult;
        $this->result->addListener($listener);
    }

    /**
     * @testdox Clean up test name $_dataName
     * @dataProvider longTestNamesDataprovider
     */
    public function testStripsDataproviderParametersFromTestName(string $testName, string $expectedTestName): void
    {
        $test = new TestCaseTest($testName);
        $test->run($this->result);

        $this->assertSame(BaseTestRunner::STATUS_ERROR, $this->cache->getState($expectedTestName));
    }

    public function longTestNamesDataprovider(): array
    {
        return [
            'ClassName::testMethod' => [
                'testSomething',
                TestCaseTest::class . '::testSomething', ],
            'ClassName::testMethod and data set number and vardump' => [
                'testMethod with data set #123 (\'a\', "A", 0, false)',
                TestCaseTest::class . '::testMethod with data set #123', ],
            'ClassName::testMethod and data set name and vardump' => [
                'testMethod with data set "data name" (\'a\', "A\", 0, false)',
                TestCaseTest::class . '::testMethod with data set "data name"', ],
        ];
    }

    public function testError(): void
    {
        $test = new \TestError('test_name');
        $test->run($this->result);

        $this->assertSame(BaseTestRunner::STATUS_ERROR, $this->cache->getState(\TestError::class . '::test_name'));
    }

    public function testFailure(): void
    {
        $test = new \Failure('test_name');
        $test->run($this->result);

        $this->assertSame(BaseTestRunner::STATUS_FAILURE, $this->cache->getState(\Failure::class . '::test_name'));
    }

    public function testSkipped(): void
    {
        $test = new \TestSkipped('test_name');
        $test->run($this->result);

        $this->assertSame(BaseTestRunner::STATUS_SKIPPED, $this->cache->getState(\TestSkipped::class . '::test_name'));
    }

    public function testIncomplete(): void
    {
        $test = new \TestIncomplete('test_name');
        $test->run($this->result);

        $this->assertSame(BaseTestRunner::STATUS_INCOMPLETE, $this->cache->getState(\TestIncomplete::class . '::test_name'));
    }

    public function testPassedTestsOnlyCacheTime(): void
    {
        $test = new \Success('test_name');
        $test->run($this->result);

        $this->assertSame(BaseTestRunner::STATUS_UNKNOWN, $this->cache->getState(\Success::class . '::test_name'));
    }

    public function testWarning(): void
    {
        $test = new \TestWarning('test_name');
        $test->run($this->result);

        $this->assertSame(BaseTestRunner::STATUS_WARNING, $this->cache->getState(\TestWarning::class . '::test_name'));
    }

    public function testRisky(): void
    {
        $test = new \TestRisky('test_name');
        $test->run($this->result);

        $this->assertSame(BaseTestRunner::STATUS_RISKY, $this->cache->getState(\TestRisky::class . '::test_name'));
    }

    public function testEmptySuite(): void
    {
        $suite = new TestSuite;
        $suite->addTestSuite(\EmptyTestCaseTest::class);
        $suite->run($this->result);

        $this->assertSame(BaseTestRunner::STATUS_WARNING, $this->cache->getState('Warning'));
    }
}
