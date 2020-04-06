<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020                                |
 | Sandor Semsey <semseysandor@gmail.com>        |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

namespace Inventory\Test\Unit\Core;

use Inventory\Core\Containers\Template;
use Inventory\Core\Controller\BaseController;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Factory;
use Inventory\Core\Renderer;
use Inventory\Core\Routing\Request;
use Inventory\Core\Routing\Router;
use Inventory\Core\Routing\Security;
use Inventory\Core\Settings;
use Inventory\Page\Login;
use Inventory\Test\Framework\BaseTestCase;

/**
 * FactoryTest Class
 *
 * @covers \Inventory\Core\Factory
 *
 * @group Framework
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
    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new Factory();
    }

    /**
     * Test creating request
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateRequestReturnsRequest()
    {
        self::assertInstanceOf(Request::class, $this->sut->createRequest());
    }

    /**
     * Test creating Security Manager
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateSecurityReturnsSecurity()
    {
        self::assertInstanceOf(Security::class, $this->sut->createSecurity());
    }

    /**
     * Test creating router
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateRouterReturnsRouter()
    {
        $security = $this->getMockBuilder(Security::class)->getMock();
        $route = ['test', 'test2'];
        self::assertInstanceOf(Router::class, $this->sut->createRouter($route, $security));
    }

    /**
     * Test creating controller
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateControllerReturnsController()
    {
        $request = self::ARRAY;
        $controller = $this->sut->createController(Login::class, $request);

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
        $request = self::ARRAY;
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
        $renderer = $this->sut->createRenderer();
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
        $settings = $this->getMockBuilder(Settings::class)->getMock();
        $this->sut = $this
          ->getMockBuilder(Factory::class)
          ->onlyMethods(['initDataBase'])
          ->getMock();

        // Expect to call initDB
        $this->sut->expects(self::once())->method('initDataBase');
        self::assertInstanceOf(SQLDataBase::class, $this->sut->createDataBase($settings));
    }

    /**
     * Test Initialize call Database init
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testInitializesDatabase()
    {
        // Mock settings
        $settings = $this->getMockBuilder(Settings::class)->getMock();
        // Mock database to not actually init DB
        $db = $this->getMockBuilder(SQLDataBase::class)->onlyMethods(['initialize'])->getMock();

        $db->expects(self::once())->method('initialize');
        $this->sut->initDataBase($db, $settings);
    }
}
