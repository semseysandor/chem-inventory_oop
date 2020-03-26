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
use PHPUnit\Runner\BaseTestRunner;
use PHPUnit\Runner\DefaultTestResultCache;

/**
 * @group test-reorder
 * @small
 */
final class TestResultCacheTest extends TestCase
{
    public function testReadsCacheFromProvidedFilename(): void
    {
        $cacheFile = TEST_FILES_PATH . '../end-to-end/execution-order/_files/MultiDependencyTest_result_cache.txt';
        $cache     = new DefaultTestResultCache($cacheFile);
        $cache->load();

        $this->assertSame(BaseTestRunner::STATUS_UNKNOWN, $cache->getState(\MultiDependencyTest::class . '::testOne'));
        $this->assertSame(BaseTestRunner::STATUS_SKIPPED, $cache->getState(\MultiDependencyTest::class . '::testFive'));
    }

    public function testDoesClearCacheBeforeLoad(): void
    {
        $cacheFile = TEST_FILES_PATH . '../end-to-end/execution-order/_files/MultiDependencyTest_result_cache.txt';
        $cache     = new DefaultTestResultCache($cacheFile);
        $cache->setState('someTest', BaseTestRunner::STATUS_FAILURE);

        $this->assertSame(BaseTestRunner::STATUS_UNKNOWN, $cache->getState(\MultiDependencyTest::class . '::testFive'));

        $cache->load();

        $this->assertSame(BaseTestRunner::STATUS_UNKNOWN, $cache->getState(\MultiDependencyTest::class . '::someTest'));
        $this->assertSame(BaseTestRunner::STATUS_SKIPPED, $cache->getState(\MultiDependencyTest::class . '::testFive'));
    }

    public function testShouldNotSerializePassedTestsAsDefectButTimeIsStored(): void
    {
        $cache = new DefaultTestResultCache;
        $cache->setState('testOne', BaseTestRunner::STATUS_PASSED);
        $cache->setTime('testOne', 123);

        $data = \serialize($cache);
        $this->assertSame('C:37:"PHPUnit\Runner\DefaultTestResultCache":64:{a:2:{s:7:"defects";a:0:{}s:5:"times";a:1:{s:7:"testOne";d:123;}}}', $data);
    }

    public function testCanPersistCacheToFile(): void
    {
        // Create a cache with one result and store it
        $cacheFile = \tempnam(\sys_get_temp_dir(), 'phpunit_');
        $cache     = new DefaultTestResultCache($cacheFile);
        $testName  = 'test' . \uniqid();
        $cache->setState($testName, BaseTestRunner::STATUS_SKIPPED);
        $cache->persist();
        unset($cache);

        // Load the cache we just created
        $loadedCache = new DefaultTestResultCache($cacheFile);
        $loadedCache->load();
        $this->assertSame(BaseTestRunner::STATUS_SKIPPED, $loadedCache->getState($testName));

        // Clean up
        \unlink($cacheFile);
    }

    public function testShouldReturnEmptyCacheWhenFileDoesNotExist(): void
    {
        $cache = new DefaultTestResultCache('/a/wrong/path/file');
        $cache->load();

        $this->assertTrue($this->isSerializedEmptyCache(\serialize($cache)));
    }

    public function testShouldReturnEmptyCacheFromInvalidFile(): void
    {
        $cacheFile = \tempnam(\sys_get_temp_dir(), 'phpunit_');
        \file_put_contents($cacheFile, '<certainly not serialized php>');

        $cache = new DefaultTestResultCache($cacheFile);
        $cache->load();

        $this->assertTrue($this->isSerializedEmptyCache(\serialize($cache)));
    }

    public function isSerializedEmptyCache(string $data): bool
    {
        return $data === 'C:37:"PHPUnit\Runner\DefaultTestResultCache":44:{a:2:{s:7:"defects";a:0:{}s:5:"times";a:0:{}}}';
    }
}
