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

namespace Inventory;

use Error;
use Exception;
use Inventory\Core\Containers\Service;
use Inventory\Core\Containers\Template;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Core\IComponent;
use Inventory\Core\Routing\Request;

/**
 * Application Class
 *
 * @category Main
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Application implements IComponent
{
    /**
     * Exception handler
     *
     * @var \Inventory\Core\Exception\ExceptionHandler|null
     */
    private ?ExceptionHandler $exHandler;

    /**
     * Service container
     *
     * @var \Inventory\Core\Containers\Service|null
     */
    private ?Service $serviceContainer;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->exHandler = null;
        $this->serviceContainer = null;
    }

    /**
     * Boot up essential components
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    private function boot()
    {
        // First the exception handler
        $this->exHandler = new ExceptionHandler();

        // Second the service container
        $this->serviceContainer = new Service();

        // Create a renderer for exception handler
        $renderer = $this->serviceContainer->factory()->createRenderer();
        $this->exHandler->setRenderer($renderer);
    }

    /**
     * Routing
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    private function routing(): array
    {
        // Parse HTTP request
        $request = $this->serviceContainer->factory()->create(Request::class);
        $route = $request->parseRoute();

        // Create Router
        $factory = $this->serviceContainer->factory();
        $security = $this->serviceContainer->security();
        $router = $factory->createRouter($route, $security);

        $router->run();

        return [
          'controller' => $router->getControllerClass(),
          'request_data' => $request->parseData(),
        ];
    }

    /**
     * Controlling
     *
     * @param array $routingData Routing information & data
     *
     * @return \Inventory\Core\Containers\Template
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    private function controlling(array $routingData): Template
    {
        // Get request data
        $request_data = $routingData['request_data'];

        // Get selected controller
        $class = $routingData['controller'];

        // Create & run controller
        $controller = $this->serviceContainer->factory()->createController($class, $request_data);

        return $controller->run();
    }

    /**
     * Rendering
     *
     * @param \Inventory\Core\Containers\Template $template Template container
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \SmartyException
     */
    private function rendering(Template $template)
    {
        $renderer = $this->serviceContainer->factory()->createRenderer($template);
        $renderer->run();
    }

    /**
     * Run Application
     */
    public function run(): void
    {
        try {
            // Boot
            $this->boot();

            // Init session
            $this->serviceContainer->security()->initSession();

            // Routing
            $router = $this->routing();

            // Controlling
            $template = $this->controlling($router);

            // Rendering
            $this->rendering($template);

            // Finish
            $this->exit();
        } catch (BadArgument | Exception | Error $ex) {
            $this->exHandler->handleFatalError();
        }
    }

    /**
     * Exit application
     */
    public function exit():void
    {
        exit;
    }
}
