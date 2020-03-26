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
 * - setUp() errors reacht he the user
 * - how many times is setUp() called?
 * - tests are not executed
 *
 * @see https://github.com/sebastianbergmann/phpunit/issues/3107
 * @see https://github.com/sebastianbergmann/phpunit/issues/3364
 */
class SetUpTest extends TestCase
{
    public function setUp(): void
    {
        throw new \RuntimeException('throw exception in setUp');
    }

    public function testOneWithSetUpException(): void
    {
        $this->fail();
    }

    public function testTwoWithSetUpException(): void
    {
        $this->fail();
    }
}
