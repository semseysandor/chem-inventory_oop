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

namespace Inventory\Core\Containers;

/**
 * Container Class for Template Data
 *
 * @category Framework
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Template
{
    /**
     * Base template
     *
     * @var string
     */
    private string $base;

    /**
     * Template regions
     *
     * @var array
     */
    private array $regions;

    /**
     * Template variables
     *
     * @var array
     */
    private array $vars;

    /**
     * Template Container constructor.
     */
    public function __construct()
    {
        $this->base = '';
        $this->regions = [];
        $this->vars = [];
    }

    /**
     * Gets base template
     *
     * @return string Base template
     */
    public function getBase(): string
    {
        return $this->base;
    }

    /**
     * Sets base template
     *
     * @param string $base Name of base template file
     */
    public function setBase(string $base): void
    {
        if (empty($base)) {
            return;
        }
        $this->base = $base;
    }

    /**
     * Get template regions
     *
     * @return array Template regions
     */
    public function getRegions(): array
    {
        return $this->regions;
    }

    /**
     * Set template region
     *
     * @param string $region Name of region (header, body, form, etc...)
     * @param string $template Template file name
     */
    public function setRegions(string $region, string $template): void
    {
        if (empty($region)) {
            return;
        }
        $this->regions[$region] = $template;
    }

    /**
     * Gets template variables
     *
     * @return array Template variables
     */
    public function getVars(): array
    {
        return $this->vars;
    }

    /**
     * Set template variables
     *
     * @param string $name Variable name
     * @param mixed $value Variable value
     */
    public function setVars(string $name, $value): void
    {
        if (empty($name)) {
            return;
        }
        $this->vars[$name] = $value;
    }
}
