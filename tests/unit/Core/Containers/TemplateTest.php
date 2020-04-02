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

namespace Inventory\Test\Unit\Core\Containers;

use Inventory\Core\Containers\Template;
use Inventory\Test\Framework\BaseTestCase;

/**
 * Template Container Test Class
 *
 * @covers \Inventory\Core\Containers\Template
 * @group minimal
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
     * SUT
     *
     * @var \Inventory\Core\Containers\Template
     */
    protected Template $sut;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->testClass = Template::class;
        $this->sut = new Template();
    }

    /**
     * Test if container is initialized
     */
    public function testContainerIsInitialized()
    {
        // Test created
        self::assertInstanceOf($this->testClass, $this->sut);

        // Test properties initialized
        self::assertNull($this->sut->getBase());
        self::assertNull($this->sut->getRegions());
        self::assertNull($this->sut->getVars());
    }

    /**
     * Test if property is accessible
     */
    public function testBaseIsAccessible()
    {
        // Write
        $expected_base = self::STRING;
        $this->sut->setBase($expected_base);

        // Read
        $actual = $this->sut->getBase();

        // Test
        self::assertSame($expected_base, $actual);
    }

    /**
     * Test if property is accessible
     */
    public function testRegionsIsAccessible()
    {
        // Write
        $expected_region = self::STRING;
        $expected_template = self::STRING_SPEC;

        // Read
        $this->sut->setRegions($expected_region, $expected_template);
        $actual = $this->sut->getRegions();

        // Test
        self::assertSame([$expected_region => $expected_template], $actual);
    }

    /**
     * Test if property is accessible
     *
     * @dataProvider provideVariableValues
     *
     * @param $value
     */
    public function testVarsIsAccessible($value)
    {
        // Write
        $expected_var = self::STRING;
        $expected_value = $value;

        // Read
        $this->sut->setVars($expected_var, $expected_value);
        $actual = $this->sut->getVars();

        // Test
        self::assertSame([$expected_var => $expected_value], $actual);
    }

    /**
     * Test properties don't change on null value
     */
    public function testPropertiesDontChangeOnNull()
    {
        // Init
        $expected_base = self::STRING;
        $this->sut->setBase($expected_base);

        $expected_region = self::STRING;
        $expected_template = self::STRING_SPEC;
        $this->sut->setRegions($expected_region, $expected_template);

        $expected_var = self::STRING;
        $expected_value = self::STRING_SPEC;
        $this->sut->setVars($expected_var, $expected_value);

        // Try to overwrite
        $this->sut->setBase('');
        $this->sut->setRegions('', self::STRING);
        $this->sut->setVars('', self::INT);

        // Read & test
        $actual = $this->sut->getBase();
        self::assertSame($expected_base, $actual);

        $actual = $this->sut->getRegions();
        self::assertSame([$expected_region => $expected_template], $actual);

        $actual = $this->sut->getVars();
        self::assertSame([$expected_var => $expected_value], $actual);
    }
}
