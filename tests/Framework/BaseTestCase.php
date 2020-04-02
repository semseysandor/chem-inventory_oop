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

namespace Inventory\Test\Framework;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

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
    protected const STRING = 'monkey';

    /**
     * Test string with special characters
     */
    protected const STRING_SPEC = ' captain *&^%@ monkey #\\';

    /**
     * Test empty string
     */
    protected const STRING_EMPTY = '';

    /**
     * Test array
     */
    protected const ARRAY = [
      self::INT,
      'monkeys' => ['orangutan', 'gorilla', 'chimpanzee'],
      'cat',
      'colonel',
      true,
      [
        'funky' => 'monkey',
        self::STRING_SPEC => self::DOUBLE,
        'dog' => false,
      ],
    ];

    /**
     * Test Integer
     */
    protected const INT = 52985;

    /**
     * Test double
     */
    protected const DOUBLE = 978.515;

    /**
     * Provides test values
     *
     * @return array
     */
    public function provideVariableValues()
    {
        return [
          'normal string' => [self::STRING],
          'special string' => [self::STRING_SPEC],
          'empty string' => [self::STRING_EMPTY],
          'integer' => [self::INT],
          'double' => [self::DOUBLE],
          'bool' => [true],
          'array' => [self::ARRAY],
        ];
    }

    /**
     * Invokes private/protected method
     *
     * @param mixed &$object Object with restricted method
     * @param string $method Name of method
     * @param array|null $params Parameters to method
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    protected function getProtectedMethod(&$object, string $method, array $params = null)
    {
        // Gets reflection
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($method);

        // Set method accessible
        $method->setAccessible(true);

        // Invoke method & return results
        return $method->invokeArgs($object, $params);
    }

    /**
     * Gets a restricted property
     *
     * @param mixed $object Object with restricted property
     * @param string $property Name of property
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    protected function getProtectedProperty(&$object, string $property)
    {
        // Get reflection
        $reflection = new ReflectionClass(get_class($object));
        $property = $reflection->getProperty($property);

        // Set property accessible
        $property->setAccessible(true);

        // Return value
        return $property->getValue($object);
    }

    /**
     * Sets a restricted property
     *
     * @param mixed $object Object with restricted property
     * @param string $property Name of property
     * @param mixed $value Value to set
     *
     * @throws \ReflectionException
     */
    protected function setProtectedProperty(&$object, string $property, $value):void
    {
        // Get reflection
        $reflection = new ReflectionClass(get_class($object));
        $property = $reflection->getProperty($property);

        // Set property accessible
        $property->setAccessible(true);

        // Set value
        $property->setValue($object, $value);
    }

    /**
     * Suppress output from test
     */
    protected function suppressOutput():void
    {
        $this->setOutputCallback(function () {
        });
    }
}
