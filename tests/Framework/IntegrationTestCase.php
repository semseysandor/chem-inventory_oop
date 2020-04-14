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

namespace Inventory\Test\Framework;

use Inventory\Core\Containers\Service;
use Inventory\Core\Containers\Template;
use Inventory\Core\DataBase\SQLDaO;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Core\Renderer;
use Inventory\Core\Routing\Request;
use Inventory\Core\Routing\Router;
use Inventory\Core\Routing\Security;

class IntegrationTestCase extends BaseTestCase
{
    use HeadlessDataBaseTrait;

    /**
     * DataBase
     *
     * @var \Inventory\Core\DataBase\SQLDataBase
     */
    protected SQLDataBase $dataBase;

    /**
     * DaO
     *
     * @var \Inventory\Core\DataBase\SQLDaO|\Inventory\Entity\Compound\DAO\Compound
     */
    protected SQLDaO $dao;

    /**
     * Template container
     *
     * @var \Inventory\Core\Containers\Template
     */
    protected Template $template;

    /**
     * Renderer
     *
     * @var \Inventory\Core\Renderer
     */
    protected Renderer $renderer;

    /**
     * Service container
     *
     * @var \Inventory\Core\Containers\Service
     */
    protected Service $service;

    /**
     * Exception handler
     *
     * @var \Inventory\Core\Exception\ExceptionHandler
     */
    protected ExceptionHandler $exHandler;

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
     * Test config file
     *
     * @var string
     */
    protected string $testConfigFile = ROOT.'/../tests/integration/TestConfigFile.php';

    public function setUpServices()
    {
        // Create Exception handler
        $this->exHandler = new ExceptionHandler();
        // Create Service container
        $this->service = new Service();

        // Init settings with test config file
        $this->service->settings($this->testConfigFile);
    }
}
