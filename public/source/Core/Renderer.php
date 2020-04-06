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

namespace Inventory\Core;

use Inventory\Core\Containers\Template;
use Inventory\Core\Exception\BaseException;
use Inventory\Core\Exception\ExceptionHandler;
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
     * Exception handler
     *
     * @var \Inventory\Core\Exception\ExceptionHandler
     */
    private Exception\ExceptionHandler $exHandler;

    /**
     * Renderer constructor.
     *
     * @param \Inventory\Core\Exception\ExceptionHandler $exHandler Exception handler
     * @param \Smarty $engine Template engine
     * @param \Inventory\Core\Containers\Template $temp_cont Template container
     */
    public function __construct(ExceptionHandler $exHandler, Smarty $engine, Template $temp_cont = null)
    {
        $this->exHandler = $exHandler;
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
     *
     * @param \Inventory\Core\Exception\BaseException $ex Exception to display*
     */
    public function displayError(BaseException $ex): void
    {
        try {
            // Init template engine
            $this->initTemplateEngine();
            $this->engine->assign('message', $ex->getMessage());
            $this->engine->assign('context', $ex->getContext());
            // Set base template file
            $base_template = ('error'.self::FILE_EXT);
            // Display template
            $this->engine->display($base_template);
        } catch (\Exception $ex) {
            $this->exHandler->handleRenderingError($ex);
        }
    }
}
