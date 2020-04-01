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

use Inventory\Core\Containers\Service;
use Inventory\Core\Controller\BaseController;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Core\Exception\InvalidRequest;
use Inventory\Core\Factory;
use Inventory\Core\IComponent;
use Inventory\Core\Renderer;
use Inventory\Core\Routing\Router;
use Inventory\Core\Routing\Security;
use SmartyException;

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
     * Router
     *
     * @var \Inventory\Core\Routing\Router|null
     */
    private ?Router $router;

    /**
     * Controller
     *
     * @var \Inventory\Core\Controller\BaseController|null
     */
    private ?BaseController $controller;

    /**
     * Renderer
     *
     * @var \Inventory\Core\Renderer|null
     */
    private ?Renderer $renderer;

    /**
     * Exception handler
     *
     * @var \Inventory\Core\Exception\ExceptionHandler|null
     */
    private ?ExceptionHandler $exHandler;

    /**
     * Factory
     *
     * @var \Inventory\Core\Factory|null
     */
    private ?Factory $factory;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->router = null;
        $this->controller = null;
        $this->renderer = null;
        $this->exHandler = null;
        $this->factory = null;
    }

    /**
     * Boot up essential components
     *
     */
    private function boot()
    {
        // First the exception handler
        $this->exHandler=new ExceptionHandler($this);

        // Second the factory
        $this->factory=new Factory();

        // Third the renderer
        $this->renderer=$this->factory->createRenderer();

        // Now renderer is ready --> give to exception handler
        $this->exHandler->setRenderer($this->renderer);
    }

    /**
     * Routing
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    private function routing()
    {
        // Create & run router
        $this->router = Service::factory()->createRouter();
        $this->router->run();
    }

    /**
     * Controlling
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \SmartyException
     */
    private function controlling()
    {
        // Get request
        $request = $this->router->getRequest();

        // Get selected controller
        $class = $this->router->getControllerClass();

        // Create & run controller
        $this->controller = Service::factory()->createController($class, $request);
        $this->controller->run();
    }

    /**
     * Run Application
     */
    public function run():void
    {
        try {
            // Boot
            $this->boot();

            // Init session
            Security::initSession();

            // Routing
            $this->routing();

            // Controlling
            $this->controlling();

            // Finish
            $this->exit();
        } catch (BadArgument | InvalidRequest $ex) {
            $this->exHandler->handleFatalError();
        } catch (SmartyException $ex) {
            $this->exHandler->handleRendererError();
        } catch (\Exception $ex) {
            echo "kakker";
        } catch (\Error $ex) {
            echo "gebasz";
            $this->exHandler->handleRendererError();
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
