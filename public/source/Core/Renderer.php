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
use Smarty;

/**
 * Renderer
 *
 * @category Render
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Renderer implements IComponent
{
    /**
     * Templates directory
     */
    private const TEMPLATE_DIR = ROOT.'/templates/';

    /**
     * Compiled templates directory
     */
    private const TEMPLATE_COMPILE_DIR = ROOT.'/cache/templates_compile/';

    /**
     * Cached templates directory
     */
    private const TEMPLATE_CACHE_DIR = ROOT.'/cache/templates_cache/';

    /**
     * Template file extension
     */
    private const FILE_EXT = '.tpl';

    /**
     * Template data container
     *
     * @var \Inventory\Core\Containers\Template
     */
    private ?Template $templateContainer;

    /**
     * Template engine
     *
     * @var \Smarty
     */
    private Smarty $engine;

    /**
     * Renderer constructor.
     *
     * @param \Smarty $engine Template engine
     * @param \Inventory\Core\Containers\Template $temp_cont Template container
     */
    public function __construct(Smarty $engine, Template $temp_cont = null)
    {
        $this->engine = $engine;
        $this->templateContainer = $temp_cont;
    }

    /**
     * Initialize template engine
     */
    private function initTemplateEngine(): void
    {
        // Set default template directory
        $this->engine->setTemplateDir(self::TEMPLATE_DIR);

        // Set compiled templates directory
        $this->engine->setCompileDir(self::TEMPLATE_COMPILE_DIR);

        // Set cache directory
        $this->engine->setCacheDir(self::TEMPLATE_CACHE_DIR);

        // TODO: development setting
        $this->engine->clearAllCache();
    }

    /**
     * Load variables to template
     */
    public function loadTemplateVars(): void
    {
        // Get variables from template container
        $vars = $this->templateContainer->getVars();

        // Check if they are set
        if (empty($vars)) {
            return;
        }

        // Load variables to template
        foreach ($vars as $name => $value) {
            $this->engine->assign($name, $value);
        }
    }

    /**
     * Load template files
     */
    private function loadTemplateFiles(): void
    {
        // Get template files from container
        $regions = $this->templateContainer->getRegions();

        // Check if they are set
        if (empty($regions)) {
            return;
        }

        // Load template files to engine
        foreach ($regions as $name => $value) {
            $this->engine->assign('_template_'.$name, $value.self::FILE_EXT);
        }
    }

    /**
     * Render page
     *
     * @throws \SmartyException
     */
    private function render(): void
    {
        // Set base template file
        $base_template = ($this->templateContainer->getBase()).self::FILE_EXT;

        // Display template
        $this->engine->display($base_template);
    }

    /**
     * Renders a template in HTML
     *
     * @return void
     *
     * @throws \SmartyException
     */
    public function run(): void
    {
        // Init template engine
        $this->initTemplateEngine();

        // Load template variables to engine
        $this->loadTemplateVars();

        // Load templates to engine
        $this->loadTemplateFiles();

        // Render page
        $this->render();
    }

    /**
     * Displays error
     */
    public function displayError():void
    {
        // TODO: implement
    }
}
