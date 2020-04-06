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

namespace Inventory\Core;

use Inventory\Core\Containers\Service;
use Inventory\Core\Containers\Template;
use Inventory\Core\Controller\BaseController;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Core\Routing\Request;
use Inventory\Core\Routing\Router;
use Inventory\Core\Routing\Security;
use Smarty;

/**
 * Factory Class
 *
 * @category Framework
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Factory
{
    /**
     * Creates a new object
     *
     * @param string $class Class to create
     * @param array|null $params Parameters pass to class
     *
     * @return mixed
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    private function create(string $class, array $params = null)
    {
        if (!class_exists($class)) {
            throw new BadArgument(ts('Tried to create non-existent class "%s"', $class));
        }
        if (!empty($params)) {
            return new $class(...$params);
        }

        return new $class();
    }

    /**
     * Creates new Request
     *
     * @return \Inventory\Core\Routing\Request
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createRequest(): Request
    {
        return $this->create(Request::class);
    }

    /**
     * Creates new Security Manager
     *
     * @return \Inventory\Core\Routing\Security
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createSecurity(): Security
    {
        return $this->create(Security::class);
    }

    /**
     * Creates Settings Manager
     *
     * @return \Inventory\Core\Settings
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createSettings(): Settings
    {
        $settings = $this->create(Settings::class);
        $settings->loadConfigFile();

        return $settings;
    }

    /**
     * Creates new Router
     *
     * @param array $route Parsed route
     * @param \Inventory\Core\Routing\Security $security Security Manager
     *
     * @return \Inventory\Core\Routing\Router
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createRouter(array $route, Security $security): Router
    {
        // Pass request to router
        return $this->create(Router::class, [$route, $security]);
    }

    /**
     * Creates new controller
     *
     * @param \Inventory\Core\Containers\Service $service
     *
     * @param string $class Name of controller to create
     * @param array|null $request_data Request Data
     *
     * @return \Inventory\Core\Controller\BaseController
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createController(Service $service, string $class, array $request_data = null): BaseController
    {
        // Check if argument is a controller class
        if (preg_match('/^Inventory\\\\(Page|Form)/', $class) != 1) {
            throw new BadArgument(ts('Tried to create non-existent controller "%s"\'', $class));
        }

        // Creates template container
        $template_container = $this->create(Template::class);

        // Creates controller and pass dependencies
        return $this->create($class, [$request_data, $template_container, $service]);
    }

    /**
     * Creates new renderer
     *
     * @param \Inventory\Core\Exception\ExceptionHandler $exHandler
     * @param \Inventory\Core\Containers\Template $temp_cont Template container
     *
     * @return \Inventory\Core\Renderer
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createRenderer(ExceptionHandler $exHandler, Template $temp_cont = null): Renderer
    {
        // Create template engine
        $engine = $this->create(Smarty::class);

        // Create renderer
        return $this->create(Renderer::class, [$exHandler, $engine, $temp_cont]);
    }

    /**
     * Creates new DataBase handler
     *
     * @param string $host DB host
     * @param int $port DB port
     * @param string $name DB name
     * @param string $user DB user
     * @param string $pass DB pass
     *
     * @return \Inventory\Core\DataBase\SQLDataBase
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function createDataBase(string $host, int $port, string $name, string $user, string $pass): SQLDataBase
    {
        $db = $this->create(SQLDataBase::class, [$host, $port, $name, $user, $pass]);
        $this->initDataBase($db);

        return $db;
    }

    /**
     * Initializes DataBase
     *
     * @param \Inventory\Core\DataBase\SQLDataBase $db
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function initDataBase(SQLDataBase &$db): void
    {
        $db->connect();
    }
}
