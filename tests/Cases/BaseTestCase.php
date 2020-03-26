<?php
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

namespace Inventory\Testing\Cases;

use PHPUnit\Framework\TestCase;

/**
 * Base Test Case
 *
 * @coversNothing
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class BaseTestCase extends TestCase
{
    /**
     * Test string
     */
    protected const TEST_STRING = 'monkey';

    /**
     * Test array
     */
    protected const TEST_ARRAY = [
      1,
      'monkeys' => ['orangutan', 'gorilla', 'chimpanzee'],
      'cat',
      'colonel',
      true,
      [
        'funky' => 'monkey',
        'terrace' => 4,
        'dog' => false,
      ],
    ];

    /**
     * FQN of class under test
     *
     * @var string
     */
    protected string $testClass;

    /**
     * Instance of class under test
     *
     * @var mixed
     */
    protected $testObject;

    /**
     * Assert object is created
     *
     * @return void
     */
    protected function assertObjectCreated(): void
    {
        self::assertInstanceOf($this->testClass, $this->testObject, 'Object not created.');
    }

    /**
     * Assert attribute is initialized
     *
     * @param string $name Name of attribute
     * @param null $default Default value
     *
     * @return void
     */
    protected function assertPropertyInitialized(string $name, $default = null): void
    {
        self::assertClassHasAttribute($name, $this->testClass, sprintf('Attribute "%s" is missing.', $name));
        self::assertSame(
          $default,
          $this->testObject->$name,
          sprintf('Default value of "%s" is not as expected.', $name)
        );
    }
}
