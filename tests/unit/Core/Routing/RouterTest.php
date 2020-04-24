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

namespace Inventory\Test\Unit\Core\Routing;

use Inventory\Core\Routing\Router;
use Inventory\Core\Routing\Security;
use Inventory\Page\Index;
use Inventory\Page\Login;
use Inventory\Page\Logout;
use Inventory\Test\Framework\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * RouterTest Class
 *
 * @covers \Inventory\Core\Routing\Router
 *
 * @group routing
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class RouterTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\Routing\Router
     */
    protected Router $sut;

    /**
     * Mock Security manager
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $security;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->security = $this
            ->getMockBuilder(Security::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['isAuthenticated'])
            ->getMock();
    }

    /**
     * Test object is initialized
     */
    public function testObjectIsInitialized()
    {
        $route = [];
        $this->sut = new Router($route, $this->security);
        self::assertInstanceOf(Router::class, $this->sut);
    }

    /**
     * Test not logged in user gets redirected to login page
     */
    public function testNotLoggedInUserIsRedirectedWhenTryToAccessPage()
    {
        $route = ['index', 'node'];
        $this->security->method('isAuthenticated')->willReturn(false);
        $this->sut = new Router($route, $this->security);

        $this->sut->run();
        self::assertSame(Login::class, $this->sut->getControllerClass());
    }

    /**
     * Tes not logged in user gets allowed to log-in form
     */
    public function testNotLoggedInUserIsLoggingInNow()
    {
        $route = ['log-in'];
        $this->security->method('isAuthenticated')->willReturn(false);
        $this->sut = new Router($route, $this->security);

        $this->sut->run();
        self::assertSame(\Inventory\Form\Login::class, $this->sut->getControllerClass());
    }

    /**
     * Test logged in user gets routed to page
     *
     * @dataProvider provideRoutes
     *
     * @param array $route Route
     * @param string $class Controller
     */
    public function testLoggedInUserTryToAccessValidPage(array $route, string $class)
    {
        $this->security->method('isAuthenticated')->willReturn(true);
        $this->sut = new Router($route, $this->security);

        $this->sut->run();
        self::assertSame($class, $this->sut->getControllerClass());
    }

    /**
     * Provide parsed routes
     *
     * @return array
     */
    public function provideRoutes()
    {
        return [
          'Log in form' => [['log-in'], \Inventory\Form\Login::class],
          'Log out page' => [['log-out'], Logout::class],
          'Login page' => [['login'], Login::class],
        ];
    }

    /**
     * Test logged in user gets redirected to index page
     */
    public function testLoggedInUserTryToAccessInvalidPage()
    {
        $route = ['invalid', 'page'];
        $this->security->method('isAuthenticated')->willReturn(true);
        $this->sut = new Router($route, $this->security);

        $this->sut->run();
        self::assertSame(Index::class, $this->sut->getControllerClass());
    }
}
