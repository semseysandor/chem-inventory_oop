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
use Inventory\Core\Exception\ExceptionHandler;
use Smarty;
use SmartyException;

/**
 * Renderer
 *
 * @category Render
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Renderer
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
     * Template data container
     *
     * @var \Inventory\Core\Container\Template
     */
    private Template $templateContainer;

    /**
     * Template engine
     *
     * @var \Smarty
     */
    private Smarty $engine;

    /**
     * Renderer constructor.
     *
     * @param \Inventory\Core\Container\Template $container
     *
     */
    public function __construct(Template $container)
    {
        try {
            if (empty($container)) {
                throw new BadArgument(ts('Template data missing for rendering'));
            }
            $this->templateContainer = $container;
            $this->initTemplateEngine();
        } catch (BadArgument $ex) {
            ExceptionHandler::handleRendererErrors($ex);
        }
    }

    /**
     * Initialize template engine
     *
     * @return void
     */
    private function initTemplateEngine(): void
    {
        $this->engine = new Smarty();

        $this->engine->setTemplateDir(self::TEMPLATE_DIR);
        $this->engine->setCompileDir(self::TEMPLATE_COMPILE_DIR);
        $this->engine->setCacheDir(self::TEMPLATE_CACHE_DIR);
        $this->engine->clearAllCache();
    }

    /**
     * Assign variables to template
     *
     * @return void
     */
    private function assignTemplateVars(): void
    {
        if (empty($this->templateContainer->vars)) {
            return;
        }
        foreach ($this->templateContainer->vars as $name => $value) {
            $this->engine->assign($name, $value);
        }
    }

    /**
     * Set template files
     *
     * @return void
     */
    private function setTemplateFiles(): void
    {
        foreach ($this->templateContainer->regions as $name => $value) {
            $this->engine->assign('_template_'.$name, $value.'.tpl');
        }
    }

    /**
     * Render page
     *
     * @return void
     *
     * @throws \SmartyException
     */
    private function render(): void
    {
        $base_template = $this->templateContainer->base.'.tpl';
        $this->engine->display($base_template);
    }

    /**
     * Renders a template in HTML
     *
     * @return void
     */
    public function run(): void
    {
        try {
            $this->assignTemplateVars();
            $this->setTemplateFiles();
            $this->render();
        } catch (SmartyException $ex) {
            ExceptionHandler::handleSmarty($ex);
        }
    }
}
