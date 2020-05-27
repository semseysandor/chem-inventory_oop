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

namespace Inventory\Core\Routing;

use Inventory\Core\IComponent;
use Inventory\Form\Compound;
use Inventory\Form\Logout;
use Inventory\Page\Batch;
use Inventory\Page\Categories;
use Inventory\Page\Forms;
use Inventory\Page\Index;
use Inventory\Page\Login;
use Inventory\Page\SubCategories;

/**
 * Router
 *
 * @category Routing
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Router implements IComponent
{
    /**
     * Security Manager
     *
     * @var \Inventory\Core\Routing\Security
     */
    private Security $security;

    /**
     * Route
     *
     * @var array
     */
    private array $route;

    /**
     * Controller class name to handle request
     *
     * @var string
     */
    private string $controllerClass;

    /**
     * Route parameters
     *
     * @var array
     */
    private array $routeParameters;

    /**
     * Router constructor.
     *
     * @param array $route Parsed route from URI
     * @param \Inventory\Core\Routing\Security $security Security Manager
     */
    public function __construct(array $route, Security $security)
    {
        $this->route = $route;
        $this->security = $security;
        $this->controllerClass = '';
        $this->routeParameters = [];
    }

    /**
     * Login
     *
     * @return string Controller class
     *
     * @throws \Inventory\Core\Exception\AuthorizationException
     */
    private function routeLogin(): string
    {
        // User logged in, proceed
        if ($this->security->isAuthenticated()) {
            return '';
        }

        // Not logged in, but logging in right now
        if ($this->route[0] == 'log-in') {
            return \Inventory\Form\Login::class;
        }

        // Not logged in AND not logging in now --> show login page
        return Login::class;
    }

    /**
     * Routing
     *
     * @return string Controller class
     */
    private function route(): string
    {
        // Routing
        switch (array_shift($this->route)) {
            case 'log-in':
                return \Inventory\Form\Login::class;

            case 'log-out':
                return Logout::class;

            case 'login':
                return Login::class;

            case 'category':
                $this->routeParameters['id'] = array_shift($this->route);
                return Categories::class;

            case 'subcategory':
                $this->routeParameters['id'] = array_shift($this->route);

                return SubCategories::class;

            case 'batch':
                $this->routeParameters['id'] = array_shift($this->route);

                return Batch::class;

            case 'form':
                $this->routeParameters['type'] = array_shift($this->route);
                $this->routeParameters['entity'] = array_shift($this->route);

                return Forms::class;

            case 'compound':
                $this->routeParameters['action'] = array_shift($this->route);

                return Compound::class;

            default:
                return Index::class;
        }
    }

    /**
     * Get route parameters
     *
     * @return array
     */
    public function getRouteParams(): array
    {
        return $this->routeParameters;
    }

    /**
     * Get controller class
     *
     * @return string
     */
    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    /**
     * Runs router
     *
     * @throws \Inventory\Core\Exception\AuthorizationException
     */
    public function run(): void
    {
        // Check if user logged in or logging in now
        $class = $this->routeLogin();

        // Class name returned from login check --> routing done
        if ($class) {
            $this->controllerClass = $class;

            return;
        }

        // Otherwise --> Standard routing
        $this->controllerClass = $this->route();
    }
}
