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
use Inventory\Core\DataBase\SQLDaO;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Core\Routing\Request;
use Inventory\Core\Routing\Router;
use Inventory\Core\Routing\Security;
use Inventory\Core\Routing\SessionManager;
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
     * @return mixed Object instantiated
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
     * @return \Inventory\Core\Routing\Request Request
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createRequest(): Request
    {
        return $this->create(Request::class);
    }

    /**
     * Creates new Session Manager
     *
     * @return \Inventory\Core\Routing\SessionManager Session Manager
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createSessionManager(): SessionManager
    {
        return $this->create(SessionManager::class);
    }

    /**
     * Creates new Security Manager
     *
     * @param \Inventory\Core\Routing\SessionManager $session_manager
     *
     * @return \Inventory\Core\Routing\Security Security Manager
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createSecurity(SessionManager $session_manager): Security
    {
        return $this->create(Security::class, [$session_manager]);
    }

    /**
     * Creates Settings Manager
     *
     * @param string $default_config_file Default config file
     *
     * @return \Inventory\Core\Settings Settings Manager
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createSettings(string $default_config_file = null): Settings
    {
        $settings = $this->create(Settings::class, [$default_config_file]);
        $settings->loadConfigFile();

        return $settings;
    }

    /**
     * Creates new Router
     *
     * @param array $route Parsed route
     * @param \Inventory\Core\Routing\Security $security Security Manager
     *
     * @return \Inventory\Core\Routing\Router Router
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
     * @param array $request_data Request Data
     *
     * @return \Inventory\Core\Controller\BaseController Controller
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createController(Service $service, string $class, array $request_data = []): BaseController
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
     * @param \Inventory\Core\Exception\ExceptionHandler $exHandler Exception handler
     * @param \Inventory\Core\Containers\Template $temp_cont Template container
     *
     * @return \Inventory\Core\Renderer Renderer
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
     * @return \Inventory\Core\DataBase\SQLDataBase DataBase Object
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
     * @param \Inventory\Core\DataBase\SQLDataBase $db DataBase Object
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    protected function initDataBase(SQLDataBase &$db): void
    {
        $db->connect();
    }

    /**
     * Creates new Dao
     *
     * @param \Inventory\Core\DataBase\SQLDataBase $database DataBase Object
     * @param string $class Dao class name
     *
     * @return \Inventory\Core\DataBase\SQLDaO DAO
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createDaO(SQLDataBase $database, string $class): SQLDaO
    {
        // Check if argument is a DaO class
        if (preg_match('/^Inventory\\\\Entity\\\\.*\\\\DAO/', $class) != 1) {
            throw new BadArgument(ts('Tried to create non-existent DaO "%s"\'', $class));
        }

        // Creates DaO and pass dependencies
        return $this->create($class, [$database]);
    }
}
