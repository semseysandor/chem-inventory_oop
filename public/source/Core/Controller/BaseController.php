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

namespace Inventory\Core\Controller;

use Inventory\Core\Containers\Template;
use Inventory\Core\Renderer;

/**
 * Base Controller Class
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
abstract class BaseController
{
    /**
     * Container for template data
     *
     * @var \Inventory\Core\Container\Template
     */
    protected Template $templateContainer;

    /**
     * Core Controller constructor.
     */
    public function __construct()
    {
        $this->templateContainer = new Template();
    }

    /**
     * Set base template file
     *
     * @param string $base_template Base template file
     *
     * @return void
     */
    protected function setBaseTemplate(string $base_template): void
    {
        $this->templateContainer->base = $base_template;
    }

    /**
     * Set template variable
     *
     * @param string $name Variable name
     * @param mixed $value Variable value
     *
     * @return void
     */
    protected function setTemplateVar($name, $value): void
    {
        if (!empty($name)) {
            $this->templateContainer->vars[$name] = $value;
        }
    }

    /**
     * Add template region
     *
     * @param string $region Region name
     * @param string $template Template File
     *
     * @return void
     */
    protected function addTemplateRegion(string $region, string $template): void
    {
        if (!empty($region) && !empty($template)) {
            $this->templateContainer->regions[$region] = $template;
        }
    }

    /**
     * Runs controller
     *
     * @return void
     */
    public function run(): void
    {
        $this->build();
        $this->render();
    }

    /**
     * Build page
     *
     * @return void
     */
    protected function build(): void
    {
        $this->validate();
        $this->process();
        $this->assemble();
    }

    /**
     * Validate input
     *
     * @return void
     */
    abstract protected function validate();

    /**
     * Process input
     *
     * @return void
     */
    abstract protected function process();

    /**
     * Assemble page
     *
     * @return void
     */
    abstract protected function assemble();

    /**
     * Render page
     *
     * @return void
     */
    protected function render()
    {
        $renderer = new Renderer($this->templateContainer);
        $renderer->run();
    }
}
