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

namespace Inventory\Test\Unit\Core;

use Inventory\Core\Containers\Service;
use Inventory\Core\Containers\Template;
use Inventory\Core\Controller\BaseController;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Factory;
use Inventory\Core\Renderer;
use Inventory\Core\Routing\Request;
use Inventory\Core\Routing\Router;
use Inventory\Core\Settings;
use Inventory\Page\Login;
use Inventory\Test\Framework\BaseTestCase;

/**
 * FactoryTest Class
 *
 * @covers \Inventory\Core\Factory
 * @group minimal
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class FactoryTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\Factory
     */
    protected Factory $sut;

    /**
     * Set up
     */
    public function setUp():void
    {
        parent::setUp();
        $services=$this->createStub(Service::class);
        $this->sut=new Factory($services);
    }

    /**
     * Test creating router
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateRouterReturnsRouter()
    {
        self::assertInstanceOf(Router::class, $this->sut->createRouter());
    }

    /**
     * Test creating controller
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateControllerReturnsController()
    {
        $request=$this->createStub(Request::class);
        $controller=$this->sut->createController(Login::class, $request);

        self::assertInstanceOf(Login::class, $controller);
    }

    /**
     * Test non-existent controller throws error
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateNonExistentControllerThrowsException()
    {
        self::expectException(BadArgument::class);
        $request=$this->createStub(Request::class);
        $this->sut->createController(BaseController::class, $request);
    }

    /**
     * Test non-existent class throws exception
     *
     * @throws \ReflectionException
     */
    public function testNonExistentClassThrowsException()
    {
        self::expectException(BadArgument::class);
        $this->invokeProtectedMethod($this->sut, 'create', ['NonExistentClass']);
    }

    /**
     * Test creating renderer
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateRendererReturnsRenderer()
    {
        $template=$this->createStub(Template::class);

        // With Template
        $renderer=$this->sut->createRenderer($template);
        self::assertInstanceOf(Renderer::class, $renderer);

        // Without template
        $renderer=$this->sut->createRenderer($template);
        self::assertInstanceOf(Renderer::class, $renderer);
    }

    /**
     * Test creating Settings Manager
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateSettingsReturnSettings()
    {
        self::assertInstanceOf(Settings::class, $this->sut->createSettings());
    }

    /**
     * Test creating DataBase
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testCreateDatabaseReturnDatabaseAndCallsInitDatabase()
    {
        // Mock factory to not actually initialize DB
        $services=$this->createStub(Service::class);
        $this->sut=$this
          ->getMockBuilder(Factory::class)
          ->setConstructorArgs([$services])
          ->onlyMethods(['initDataBase'])
          ->getMock();

        // Expect to call initDB
        $this->sut->expects(self::once())->method('initDataBase');
        self::assertInstanceOf(SQLDataBase::class, $this->sut->createDataBase());
    }

    /**
     * Test Initialize call Database init
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testInitializesDatabase()
    {
        // Stub settings
        $settings=$this->createStub(Settings::class);
        // Mock service to return settings stub
        $services=$this->getMockBuilder(Service::class)->onlyMethods(['settings'])->getMock();
        $services->method('settings')->willReturn($settings);
        // Give mock service to factory
        $this->sut=new Factory($services);
        // Mock database to not actually init DB
        $db=$this->getMockBuilder(SQLDataBase::class)->onlyMethods(['initialize'])->getMock();

        $db->expects(self::once())->method('initialize');
        $this->sut->initDataBase($db);
    }
}