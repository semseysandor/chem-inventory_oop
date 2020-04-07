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

namespace Inventory\Test\Integration;

use Inventory\Core\Routing\Request;
use Inventory\Core\Routing\Router;
use Inventory\Core\Routing\Security;
use Inventory\Page\Index;
use Inventory\Page\Login;
use Inventory\Test\Framework\BaseTestCase;

/**
 * Routing Integration Test Class
 *
 * @covers \Inventory\Core\Routing\Request
 * @covers \Inventory\Core\Routing\Router
 * @covers \Inventory\Core\Routing\Security
 *
 * @group backend
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class RoutingTest extends BaseTestCase
{
    /**
     * Request
     *
     * @var \Inventory\Core\Routing\Request
     */
    protected Request $request;

    /**
     * Router
     *
     * @var \Inventory\Core\Routing\Router
     */
    protected Router $router;

    /**
     * Security
     *
     * @var \Inventory\Core\Routing\Security
     */
    protected Security $security;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->request = new Request();
        $this->security = new Security();
    }

    /**
     * Test valid request from not logged in user
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function testValidRequestFromNotLoggedInUser()
    {
        // Set up environment
        unset($_SESSION);
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/index';

        $route = $this->request->parseRoute();
        $this->router = new Router($route, $this->security);
        $this->router->run();

        self::assertSame(Login::class, $this->router->getControllerClass());
    }

    /**
     * Test valid request from logged in user
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function testValidRequestFromLoggedInUser()
    {
        // Set up environment
        $_SESSION['USER_NAME'] = 'test';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';

        $route = $this->request->parseRoute();
        $this->router = new Router($route, $this->security);
        $this->router->run();

        self::assertSame(Index::class, $this->router->getControllerClass());
    }
}
