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

namespace Inventory\Core;

use Inventory\Core\Containers\Template;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Routing\Request;
use Inventory\Core\Routing\Router;
use Smarty;

/**
 * Factory Class
 *
 * @category Main
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
     *
     * @param array|null $params Parameters pass to class
     *
     * @return mixed
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function create(string $class, array $params = null)
    {
        if (!class_exists($class)) {
            throw new BadArgument(ts(sprintf('Tried to create non-existent class "%s"', $class)));
        }
        if (!empty($params)) {
            return new $class(...$params);
        }
        return new $class();
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
     * @return \Inventory\Core\Routing\Router
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createRouter()
    {
        // Create request
        $request = $this->create(Request::class);

        // Pass request to router
        return $this->create(Router::class, [$request]);
    }

    /**
     * Creates new controller
     *
     * @param string $class Name of controller to create
     * @param \Inventory\Core\Routing\Request $request HTTP request
     *
     * @return \Inventory\Core\Controller\BaseController
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createController(string $class, Request $request)
    {
        // Check if argument is a controller class
        if (preg_match('/^Inventory\\\\(Page|Form)/', $class) != 1) {
            throw new BadArgument(ts(sprintf('Tried to create non-existent controller "%s"\'', $class)));
        }

        // Creates template container
        $template = $this->create(Template::class);

        // Creates renderer with the same template container
        $renderer = $this->createRenderer($template);

        // Creates controller and pass dependencies
        return $this->create($class, [$request, $template, $renderer]);
    }

    /**
     * Creates new renderer
     *
     * @param \Inventory\Core\Containers\Template $temp_cont Template container
     *
     * @return \Inventory\Core\Renderer
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function createRenderer(Template $temp_cont = null)
    {
        // Create template engine
        $engine = $this->create(Smarty::class);

        // Create renderer
        return $this->create(Renderer::class, [$engine, $temp_cont]);
    }
}
