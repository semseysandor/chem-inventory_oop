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

namespace Inventory;

use Inventory\Core\Controller\CoreController;
use Inventory\Core\Renderer;
use Inventory\Core\Routing\Router;

/**
 * Application
 *
 * @category Main
 * @package  Inventory
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Application
{
    /**
     * Router
     *
     * @var \Inventory\Core\Routing\Router
     */
    private Router $router;

    /**
     * Controller
     *
     * @var \Inventory\Core\Controller\CoreController
     */
    private CoreController $controller;

    /**
     * Renderer
     *
     * @var \Inventory\Core\Renderer
     */
    private Renderer $renderer;

    public function __construct()
    {
        $this->initSession();
    }

    /**
     * Run application
     *
     * @throws \SmartyException
     */
    public function run()
    {
        // Routing
        $this->router = new Router();
        $route = $this->router->route();

        // Controller
        $this->controller = new $route();
        $template = $this->controller->build();
        if (empty($template)) {
            exit;
        }

        // Rendering
        $this->renderer = new Renderer();
        $this->renderer->render($template);
    }

    private function initSession()
    {
        // Start session
        session_start();

        // Abort script if session not loaded
        if (session_status() != PHP_SESSION_ACTIVE) {
            self::exit(ts('Session start failed.'));
        }
    }

    public static function exit(string $reason)
    {
        echo $reason;
        exit;
    }
}
