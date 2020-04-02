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

use Inventory\Core\Containers\Service;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Factory;
use Inventory\Core\Settings;
use Inventory\Test\Framework\BaseTestCase;

/**
 * ServiceTest Class
 *
 * @covers \Inventory\Core\Containers\Service
 * @group minimal
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
    public function setUp():void
    {
        parent::setUp();
        $this->sut=new Service();
    }

    /**
     * Return Setting Manager Object and same object every time
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testReturnSettingsManagerAndAlwaysSameObject()
    {
        $settings=$this->sut->settings();
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
