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

/**
 * @runTestsInSeparateProcesses
 * @runClassInSeparateProcess
 */
class TestWithAnnotations extends TestCase
{
    public static function providerMethod()
    {
        return [[0]];
    }

    /**
     * @backupGlobals enabled
     */
    public function testThatInteractsWithGlobalVariables(): void
    {
    }

    /**
     * @backupStaticAttributes enabled
     */
    public function testThatInteractsWithStaticAttributes(): void
    {
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testInSeparateProcess(): void
    {
    }

    /**
     * @backupGlobals enabled
     * @dataProvider providerMethod
     */
    public function testThatInteractsWithGlobalVariablesWithDataProvider(): void
    {
    }

    /**
     * @backupStaticAttributes enabled
     * @dataProvider providerMethod
     */
    public function testThatInteractsWithStaticAttributesWithDataProvider(): void
    {
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @dataProvider providerMethod
     */
    public function testInSeparateProcessWithDataProvider(): void
    {
    }
}
