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

use Inventory\Core\Factory;
use Inventory\Core\Routing\Security;
use Inventory\Core\Settings;

/**
 * Service container for accessing major subsystems
 *
 * @category Framework
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Service
{
    /**
     * Factory
     *
     * @var \Inventory\Core\Factory|null
     */
    private ?Factory $factory;

    /**
     * Settings Manager
     *
     * @var \Inventory\Core\Settings|null
     */
    private ?Settings $settings;

    /**
     * Security Manager
     *
     * @var \Inventory\Core\Routing\Security|null
     */
    private ?Security $security;

    /**
     * Service constructor.
     */
    public function __construct()
    {
        $this->factory = null;
        $this->settings = null;
        $this->security = null;
    }

    /**
     * Gets the security subsystem
     *
     * @return \Inventory\Core\Routing\Security
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function security()
    {
        // Pseudo-singleton
        if ($this->security == null) {
            $this->security = $this->factory()->create(Security::class);
        }

        return $this->security;
    }

    /**
     * Gets the settings subsystem
     *
     * @return \Inventory\Core\Settings
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function settings()
    {
        // Pseudo-singleton
        if ($this->settings == null) {
            $this->settings = $this->factory()->createSettings();
        }

        return $this->settings;
    }

    /**
     * Gets the DataBase handler
     *
     * @return \Inventory\Core\DataBase\SQLDataBase
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function database()
    {
        return $this->factory()->createDataBase($this->settings());
    }

    /**
     * Gets the factory
     *
     * @return \Inventory\Core\Factory|null
     */
    public function factory()
    {
        // Pseudo-singleton
        if ($this->factory == null) {
            $this->factory = new Factory();
        }

        return $this->factory;
    }
}
