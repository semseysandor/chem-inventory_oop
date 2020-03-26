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

/**
 * Class SetUpBeforeClassTest
 *
 * Behaviour to test:
 * - setUpBeforeClass() errors do reach the user
 * - setUp() is not run
 * - how many times is setUpBeforeClass() called?
 * - tests are not executed
 *
 * @see https://github.com/sebastianbergmann/phpunit/issues/2145
 * @see https://github.com/sebastianbergmann/phpunit/issues/3107
 * @see https://github.com/sebastianbergmann/phpunit/issues/3364
 */
class SetUpBeforeClassTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        throw new \Exception('forcing an Exception in setUpBeforeClass()');
    }

    public function setUp(): void
    {
        throw new \Exception('setUp() should never have been run');
    }

    public function testOne(): void
    {
        $this->assertTrue(true);
    }

    public function testTwo(): void
    {
        $this->assertTrue(true);
    }
}
