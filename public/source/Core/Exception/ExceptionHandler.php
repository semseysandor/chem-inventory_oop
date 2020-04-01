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

namespace Inventory\Core\Exception;

use Inventory\Application;
use Inventory\Core\Renderer;

/**
 * Exception Handler
 *
 * @category Exception
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class ExceptionHandler
{
    /**
     * Application
     *
     * @var \Inventory\Application
     */
    private Application $app;

    /**
     * Renderer
     *
     * @var \Inventory\Core\Renderer
     */
    private ?Renderer $renderer;

    /**
     * ExceptionHandler constructor.
     *
     * @param \Inventory\Application $app Application
     * @param \Inventory\Core\Renderer|null $renderer Renderer
     */
    public function __construct(Application $app, Renderer $renderer = null)
    {
        $this->app=$app;
        $this->renderer=$renderer;
    }

    /**
     * Set renderer
     *
     * @param \Inventory\Core\Renderer $renderer
     */
    public function setRenderer(Renderer $renderer)
    {
        $this->renderer=$renderer;
    }

    /**
     * Handles renderer error
     */
    public function handleRendererError(): void
    {
        $this->displayStaticError();
        $this->app->exit();
    }

    /**
     * Handles fatal error
     */
    public function handleFatalError():void
    {
        // Display error
        $this->renderer->displayError();

        // Exit application
        $this->app->exit();
    }

    /**
     * Display static error page
     */
    protected function displayStaticError()
    {
        echo "renderer error";
    }
}
