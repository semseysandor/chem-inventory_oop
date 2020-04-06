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

use Inventory\Core\DataBase\SQLDataBase;
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
     * DataBase
     *
     * @var \Inventory\Core\DataBase\SQLDataBase|null
     */
    private ?SQLDataBase $dataBase;

    /**
     * Service constructor.
     */
    public function __construct()
    {
        $this->factory = null;
        $this->settings = null;
        $this->security = null;
        $this->dataBase = null;
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
            $this->security = $this->factory()->createSecurity();
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
        // Pseudo-singleton
        if ($this->dataBase == null) {
            // Get configs
            $host = $this->settings()->getSetting('db', 'host');
            $port = $this->settings()->getSetting('db', 'port');
            $name = $this->settings()->getSetting('db', 'name');
            $user = $this->settings()->getSetting('db', 'user');
            $pass = $this->settings()->getSetting('db', 'pass');

            $this->dataBase = $this->factory()->createDataBase($host, $port, $name, $user, $pass);
        }

        return $this->dataBase;
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
