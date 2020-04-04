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

use Inventory\Core\Containers\Template;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Exception\BadArgument;
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
     * Factory constructor.
     */
    public function __construct()
    {
    }

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
    public function createSettings()
    {
        return $this->create(Settings::class);
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
    public function createRouter(array $route, Security $security)
    {
        // Pass request to router
        return $this->create(Router::class, [$route, $security]);
    }

    /**
     * Creates new controller
     *
     * @param string $class Name of controller to create
     * @param array|null $request_data Request Data
     *
     * @return \Inventory\Core\Controller\BaseController
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createController(string $class, array $request_data = null)
    {
        // Check if argument is a controller class
        if (preg_match('/^Inventory\\\\(Page|Form)/', $class) != 1) {
            throw new BadArgument(ts('Tried to create non-existent controller "%s"\'', $class));
        }

        // Creates template container
        $template_container = $this->create(Template::class);

        // Creates controller and pass dependencies
        return $this->create($class, [$request_data, $template_container, $this]);
    }

    /**
     * Creates new renderer
     *
     * @param \Inventory\Core\Containers\Template $temp_cont Template container
     *
     * @return \Inventory\Core\Renderer
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createRenderer(Template $temp_cont = null)
    {
        // Create template engine
        $engine = $this->create(Smarty::class);

        // Create renderer
        return $this->create(Renderer::class, [$engine, $temp_cont]);
    }

    /**
     * Creates new DataBase handler
     *
     * @param \Inventory\Core\Settings $settings
     *
     * @return \Inventory\Core\DataBase\SQLDataBase
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function createDataBase(Settings $settings)
    {
        $db = $this->create(SQLDataBase::class);
        $this->initDataBase($db, $settings);

        return $db;
    }

    /**
     * Initialize DataBase
     *
     * @param \Inventory\Core\DataBase\SQLDataBase $dataBase DB to initialize
     * @param \Inventory\Core\Settings $settings Setting Manager
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function initDataBase(SQLDataBase &$dataBase, Settings $settings)
    {
        $dataBase->initialize($settings);
    }
}
