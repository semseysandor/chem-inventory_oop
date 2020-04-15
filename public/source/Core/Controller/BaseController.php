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

namespace Inventory\Core\Controller;

use Inventory\Core\Containers\Service;
use Inventory\Core\Containers\Template;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\IComponent;

/**
 * Base Controller Class
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class BaseController implements IComponent
{
    /**
     * HTTP request data
     *
     * @var array
     */
    protected array $requestData;

    /**
     * Container for template data
     *
     * @var \Inventory\Core\Containers\Template
     */
    protected Template $templateContainer;

    /**
     * Service container
     *
     * @var \Inventory\Core\Containers\Service
     */
    protected Service $service;

    /**
     * Core Controller constructor.
     *
     * @param array $request_data Request data
     * @param \Inventory\Core\Containers\Template $temp_cont Template container
     * @param \Inventory\Core\Containers\Service $service Service container
     */
    public function __construct(array $request_data, Template $temp_cont, Service $service)
    {
        $this->requestData = $request_data;
        $this->templateContainer = $temp_cont;
        $this->service = $service;
    }

    /**
     * Set base template file
     *
     * @param string $base_template Base template file
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function setBaseTemplate(string $base_template): void
    {
        if (empty($base_template)) {
            throw new BadArgument(ts('Base template missing at "%s".', self::class));
        }
        $this->templateContainer->setBase($base_template);
    }

    /**
     * Set template variable
     *
     * @param string $name Variable name
     * @param mixed $value Variable value
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function setTemplateVar(string $name, $value): void
    {
        if (empty($name)) {
            throw new BadArgument(ts('Template variable name missing at "%s".', self::class));
        }
        $this->templateContainer->setVars($name, $value);
    }

    /**
     * Add template region
     *
     * @param string $region Region name
     * @param string $template Template File
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function setTemplateRegion(string $region, string $template): void
    {
        if (empty($region)) {
            throw new BadArgument(ts('Template region name missing at "%s".', self::class));
        }
        $this->templateContainer->setRegions($region, $template);
    }

    /**
     * Gets Template container
     *
     * @return \Inventory\Core\Containers\Template Template container
     */
    public function getTemplateContainer(): Template
    {
        return $this->templateContainer;
    }

    /**
     * Validate input
     */
    protected function validate(): void
    {
    }

    /**
     * Process input
     */
    protected function process(): void
    {
    }

    /**
     * Assemble page
     */
    protected function assemble(): void
    {
    }

    /**
     * Runs controller
     *
     * @return Template Template container
     */
    public function run(): Template
    {
        // Validate inputs
        $this->validate();

        // Process inputs
        $this->process();

        // Assemble page
        $this->assemble();

        return $this->getTemplateContainer();
    }
}
