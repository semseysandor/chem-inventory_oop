<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020 Sandor Semsey                  |
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
     * @var string|null
     */
    private ?string $base;

    /**
     * Template regions
     *
     * @var array|null
     */
    private ?array $regions;

    /**
     * Template variables
     *
     * @var array|null
     */
    private ?array $vars;

    /**
     * Template Container constructor.
     */
    public function __construct()
    {
        $this->base = null;
        $this->regions = null;
        $this->vars = null;
    }

    /**
     * Gets base template
     *
     * @return string|null
     */
    public function getBase(): ?string
    {
        return $this->base;
    }

    /**
     * Sets base template
     *
     * @param string $base Name of base template file
     *
     * @return void
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
     * @return array|null
     */
    public function getRegions(): ?array
    {
        return $this->regions;
    }

    /**
     * Set template region
     *
     * @param string $region Name of region (header, body, form, etc...)
     * @param string $template Template file name
     *
     * @return void
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
     * @return array|null
     */
    public function getVars(): ?array
    {
        return $this->vars;
    }

    /**
     * Set template variables
     *
     * @param string $name Variable name
     * @param mixed $value Variable value
     *
     * @return void
     */
    public function setVars(string $name, $value): void
    {
        if (empty($name)) {
            return;
        }
        $this->vars[$name] = $value;
    }
}
