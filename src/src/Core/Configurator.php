<?php

/**
 * This file is part of chem-inventory.
 * Written by Sandor Semsey.
 *
 * Copyright (c)  2020.
 * This is work licenced under the GNU General Public License v3.0. All rights reserved.
 *
 * This is a free software;)
 */

namespace Inventory\Core;

class Configurator
{
    private $config;

    private static $instance;

    /**
     * Configurator constructor.
     *
     */
    private function __construct()
    {
        $this->config = self::getDefaults();
    }

    private static function getDefaults(): array
    {
        $configFile = ROOT.'/config.php';
        if (!file_exists($configFile)) {
            return [];
        }

        return include($configFile);
    }

    public static function singleton()
    {
        if (self::$instance === null) {
            self::$instance = new Configurator();
        }

        return self::$instance;
    }

    public function getConfig(string $key)
    {
        if (!array_key_exists($key, $this->config)) {
            return null;
        }

        return $this->config[$key];
    }

    public function addConfig(array $cfgToAdd): void
    {
        foreach ($cfgToAdd as $key => $value) {
            $this->config[$key] = $value;
        }
    }
}
