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

namespace Inventory\Testing\Core\Containers;

use Inventory\Core\Containers\Template;
use Inventory\Testing\Cases\BaseTestCase;

/**
 * Template Test Class
 *
 * @covers \Inventory\Core\Containers\Template
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class TemplateTest extends BaseTestCase
{
    /**
     * Set up method
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->testClass = 'Inventory\Core\Containers\Template';
        $this->testObject = new Template();
    }

    /**
     * Test if container is initialized
     */
    public function testContainerIsInitialized()
    {
        $this->assertObjectCreated();

        $this->assertPropertyInitialized('base');
        $this->assertPropertyInitialized('regions');
        $this->assertPropertyInitialized('vars');
    }

    /**
     * Test if properties can be read/written
     *
     * @dataProvider attributeValues
     *
     * @param string $name Name of property
     * @param mixed $value Test value
     */
    public function testPropertiesAreAccessible($name, $value)
    {
        $this->testObject->$name = $value;
        self::assertSame($this->testObject->$name, $value, sprintf('Property "%s" not accessible.', $name));
    }

    /**
     * Provides test values for properties
     *
     * @return array
     */
    public function attributeValues(): array
    {
        return [
          ['base', self::TEST_STRING],
          ['regions', self::TEST_ARRAY],
          ['vars', self::TEST_ARRAY],

        ];
    }
}
