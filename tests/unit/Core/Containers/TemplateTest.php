<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | (c) Sandor Semsey <semseysandor@gmail.com>    |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 |                                               |
 | It's a free software;)                        |
 +-----------------------------------------------+
 */

/**
 * +-----------------------------------------------+
 * | This file is part of chem-inventory.          |
 * |                                               |
 * | (c) Sandor Semsey <semseysandor@gmail.com>    |
 * | All rights reserved.                          |
 * |                                               |
 * | This work is published under the MIT License. |
 * | https://choosealicense.com/licenses/mit/      |
 * |                                               |
 * | It's a free software;)                        |
 * +-----------------------------------------------+
 */

namespace Inventory\Test\Unit\Core\Containers;

use Inventory\Core\Containers\Template;
use Inventory\Test\Framework\BaseTestCase;

/**
 * Template Container Test Class
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
        $this->sut = new Template();
    }

    /**
     * Test if container is initialized
     */
    public function testObjectIsInitialized()
    {
        self::assertInstanceOf(Template::class, $this->sut);
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
        self::assertSame($expected_base, $this->sut->getBase());
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
        self::assertSame([$expected_region => $expected_template], $this->sut->getRegions());
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
        self::assertSame([$expected_var => $expected_value], $this->sut->getVars());
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
        self::assertSame($expected_base, $this->sut->getBase());
        self::assertSame([$expected_region => $expected_template], $this->sut->getRegions());
        self::assertSame([$expected_var => $expected_value], $this->sut->getVars());
    }
}
