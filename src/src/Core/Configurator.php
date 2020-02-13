<?php

/**
 * This file is part of chem-inventory.
 * Written by Sandor Semsey.
 *
 * Copyright (c) 2020.
 * This is work licenced under the GNU General Public License v3.0. All rights reserved.
 *
 * This is a free software;)
 */

namespace Inventory\Core;

class Configurator
{
    public static $config;

    private static $instance;

    /**
     * Configurator constructor.
     *
     */
    private function __construct()
    {
    }

    public static function singleton()
    {
        if (self::$instance === null) {
            self::$instance = new Configurator();
        }

        return self::$instance;
    }

    public static function getDefaults()
    {
        self::$config = ROOT . 'config.php';
    }
}
