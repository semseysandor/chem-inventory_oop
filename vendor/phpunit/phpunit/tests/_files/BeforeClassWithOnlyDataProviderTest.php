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
class BeforeClassWithOnlyDataProviderTest extends \PHPUnit\Framework\TestCase
{
    public static $setUpBeforeClassWasCalled;

    public static $beforeClassWasCalled;

    public static function resetProperties(): void
    {
        self::$setUpBeforeClassWasCalled = false;
        self::$beforeClassWasCalled      = false;
    }

    /**
     * @beforeClass
     */
    public static function someAnnotatedSetupMethod(): void
    {
        self::$beforeClassWasCalled = true;
    }

    public static function setUpBeforeClass(): void
    {
        self::$setUpBeforeClassWasCalled = true;
    }

    public function dummyProvider()
    {
        return [[1]];
    }

    /**
     * @dataProvider dummyProvider
     * delete annotation to fail test case
     */
    public function testDummy(): void
    {
        $this->assertFalse(false);
    }
}
