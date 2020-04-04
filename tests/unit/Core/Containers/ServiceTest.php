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

use Inventory\Core\Containers\Service;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Factory;
use Inventory\Core\Routing\Security;
use Inventory\Core\Settings;
use Inventory\Test\Framework\BaseTestCase;

/**
 * ServiceTest Class
 *
 * @covers \Inventory\Core\Containers\Service
 *
 * @group Framework
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class ServiceTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\Containers\Service
     */
    protected Service $sut;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new Service();
    }

    /**
     * Return Security Manager Object and same object every time
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testReturnSecurityManagerAndAlwaysSameObject()
    {
        $security = $this->sut->security();
        self::assertInstanceOf(Security::class, $security);

        // Modify object and test if same object returned
        $security->test = 'test';
        self::assertEquals($security, $this->sut->security());
    }

    /**
     * Return Setting Manager Object and same object every time
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testReturnSettingsManagerAndAlwaysSameObject()
    {
        $settings = $this->sut->settings();
        self::assertInstanceOf(Settings::class, $settings);

        // Modify object and test if same object returned
        $settings->test='test';
        self::assertEquals($settings, $this->sut->settings());
    }

    /**
     * Return Factory Object and same object every time
     */
    public function testReturnFactoryAndAlwaysSameObject()
    {
        $factory=$this->sut->factory();
        self::assertInstanceOf(Factory::class, $factory);

        // Modify object and test if same object returned
        $factory->test='test';
        self::assertEquals($factory, $this->sut->factory());
    }

    /**
     * Return DataBase object and a new instance every time
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \ReflectionException
     */
    public function testReturnDataBaseObjectAndAlwaysNewObject()
    {
        // Mock factory to not initialize DB
        $service=$this->createStub(Service::class);
        $factory=$this
          ->getMockBuilder(Factory::class)
          ->setConstructorArgs([$service])
          ->onlyMethods(['initDataBase'])
          ->getMock();

        // Give mock factory to SUT
        $this->setProtectedProperty($this->sut, 'factory', $factory);

        $database_return=$this->sut->database();
        self::assertInstanceOf(SQLDataBase::class, $database_return);

        // Modify object and test if different object returned
        $database_return->test='test';
        self::assertNotEquals($database_return, $this->sut->database());
    }
}
