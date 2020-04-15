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

namespace Inventory;

use Inventory\Core\Containers\Service;
use Inventory\Core\Containers\Template;
use Inventory\Core\Exception\AuthorizationException;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Core\Exception\InvalidRequest;
use Inventory\Core\Exception\RenderingError;
use Inventory\Core\IComponent;

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
    private function boot(): void
    {
        // First the exception handler
        $this->exHandler = new ExceptionHandler();

        // Second the service container
        $this->serviceContainer = new Service();

        // Create a renderer for exception handler
        $renderer = $this->serviceContainer->factory()->createRenderer($this->exHandler);
        $this->exHandler->setRenderer($renderer);
    }

    /**
     * Routing
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    private function routing(): array
    {
        // Parse HTTP request
        $request = $this->serviceContainer->factory()->createRequest();
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
     * @return \Inventory\Core\Containers\Template Template container
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
        $controller = $this
          ->serviceContainer
          ->factory()
          ->createController($this->serviceContainer, $class, $request_data);

        return $controller->run();
    }

    /**
     * Rendering
     *
     * @param \Inventory\Core\Containers\Template $template Template container
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\RenderingError
     */
    private function rendering(Template $template): void
    {
        $renderer = $this->serviceContainer->factory()->createRenderer($this->exHandler, $template);
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
        } catch (AuthorizationException | BadArgument | InvalidRequest $ex) {
            $this->exHandler->handleFatalError($ex);
        } catch (RenderingError $ex) {
            $this->exHandler->handleRenderingError($ex);
        }
    }

    /**
     * Exit application
     */
    public function exit(): void
    {
        exit;
    }
}
