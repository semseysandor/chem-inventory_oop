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

use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Core\Exception\InvalidRequest;
use Inventory\Page\Index;
use Inventory\Page\Login;

/**
 * Router
 *
 * @category Routing
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Router
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
    private array $route;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->getRouteFromURL();
    }

    /**
     * Route
     *
     * @return void
     */
    private function route(): void
    {
        $this->isLoggedIn();

        // Default route
        if (empty($this->route[0])) {
            $controller = new Index();
            $controller->run();
            exit;
        }

        // Route
        switch (array_shift($this->route)) {
            case 'log-in':
                $controller = new \Inventory\Form\Login($this->request->requestData);
                break;
            case 'log-out':
                Security::logOut();
                header('Location: /');
                exit;
            case 'login':
                $controller = new Login();
                break;
            default:
                $controller = new Index();
        }

        $controller->run();
        exit;
    }

    /**
     * Get route info from URL
     *
     * @return void
     */
    private function getRouteFromURL(): void
    {
        try {
            $this->request = new Request();
            $this->request->parse();
            $this->route = $this->request->route;
        } catch (InvalidRequest $ex) {
            ExceptionHandler::handleInvalidRequest($ex);
        }
    }

    /**
     * Check if user is logged in
     *
     * @return void
     */
    private function isLoggedIn(): void
    {
        // Security
        if (!Security::isAuthorized()) {
            if ($this->route[0] == 'log-in') {
                // Not logged in, but logging in right now
                $controller = new \Inventory\Form\Login($this->request->requestData);
                $controller->run();
            } else {
                // Not logging in, show login page
                $controller = new Login();
                $controller->run();
            }
            exit;
        }
    }

    /**
     * Runs router
     */
    public function run()
    {
        $this->route();
    }
}
