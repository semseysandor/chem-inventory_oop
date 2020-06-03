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
use Inventory\Core\Routing\SessionManager;
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
     * Session Manager
     *
     * @var \Inventory\Core\Routing\SessionManager|null
     */
    private ?SessionManager $sessions;

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
        $this->sessions = null;
        $this->security = null;
        $this->dataBase = null;
    }

    /**
     * Gets the Session Manager
     *
     * @return \Inventory\Core\Routing\SessionManager Session Manager
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function sessionManager(): SessionManager
    {
        // Pseudo-singleton
        if (is_null($this->sessions)) {
            $this->sessions = $this->factory()->createSessionManager();
        }

        return $this->sessions;
    }

    /**
     * Gets the security subsystem
     *
     * @return \Inventory\Core\Routing\Security Security Manager
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function security(): Security
    {
        // Pseudo-singleton
        if (is_null($this->security)) {
            $this->security = $this->factory()->createSecurity($this->sessionManager());
        }

        return $this->security;
    }

    /**
     * Gets the settings subsystem
     *
     * @param string $default_config_file Default config file
     *
     * @return \Inventory\Core\Settings Setting Manager
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function settings(string $default_config_file = null): Settings
    {
        // If no default config file specified fallback to default
        if (is_null($default_config_file)) {
            $default_config_file = Settings::DEFAULT_CONFIG_FILE;
        }

        // Pseudo-singleton
        if (is_null($this->settings)) {
            $this->settings = $this->factory()->createSettings($default_config_file);
        }

        return $this->settings;
    }

    /**
     * Gets the DataBase handler
     *
     * @return \Inventory\Core\DataBase\SQLDataBase DataBase
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function database(): SQLDataBase
    {
        // Pseudo-singleton
        if (is_null($this->dataBase)) {
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
     * @return \Inventory\Core\Factory Factory
     */
    public function factory(): Factory
    {
        // Pseudo-singleton
        if (is_null($this->factory)) {
            $this->factory = new Factory();
        }

        return $this->factory;
    }
}
