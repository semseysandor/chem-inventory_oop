<?php
/**
 +---------------------------------------------------------------------+
 | This file is part of chem-inventory.                                |
 |                                                                     |
 | Copyright (c) 2020 Sandor Semsey                                    |
 | All rights reserved.                                                |
 |                                                                     |
 | This work is published under the MIT License.                       |
 | https://choosealicense.com/licenses/mit/                            |
 |                                                                     |
 | It's a free software;)                                              |
 |                                                                     |
 | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 | SOFTWARE.                                                           |
 +---------------------------------------------------------------------+
 */

namespace Inventory\Core\Routing;

use Inventory\Core\IComponent;
use Inventory\Page\Index;
use Inventory\Page\Login;
use Inventory\Page\Logout;

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
     * Request
     *
     * @var \Inventory\Core\Routing\Request
     */
    private Request $request;

    /**
     * Route
     *
     * @var array
     */
    private ?array $route;

    /**
     * Controller class name to handle request
     *
     * @var string|null
     */
    private ?string $controllerClass;

    /**
     * Router constructor.
     *
     * @param \Inventory\Core\Routing\Request $request HTTP request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->route = null;
        $this->controllerClass = null;
    }

    /**
     * Get route info from URL
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    private function getRouteInfo(): void
    {
        // Parse URL
        $this->request->parse();

        // Get route
        $this->route = $this->request->getRoute();
    }

    /**
     * Login
     *
     * @return string
     */
    private function routeLogin(): string
    {
        // User logged in, proceed
        if (Security::isAuthorized()) {
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
     * @return string
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
            default:
                return Index::class;
        }
    }

    /**
     * Get request
     *
     * @return \Inventory\Core\Routing\Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Get controller class
     *
     * @return string|null
     */
    public function getControllerClass(): ?string
    {
        return $this->controllerClass;
    }

    /**
     * Runs router
     *
     * @return \Inventory\Core\Routing\Router
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function run(): Router
    {
        // Parse request
        $this->getRouteInfo();

        // Check if user logged in or logging in now
        $class = $this->routeLogin();
        if ($class) {
            $this->controllerClass = $class;

            return $this;
        }

        // User logged in --> Standard routing
        $this->controllerClass = $this->route();

        return $this;
    }
}
