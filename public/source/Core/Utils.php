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

namespace Inventory\Core;

/**
 * Utilities
 *
 * @category Framework
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Utils
{
    /**
     * Gets Path from Class name (Namespace -> Path)
     *
     * @param string $class Class name
     *
     * @return string
     */
    public static function getPathFromClass(string $class): string
    {
        // Check if class exist
        if (!class_exists($class)) {
            return '';
        }

        // Change '\' to '/'
        $path = str_replace('\\', '/', $class);

        // Remove leading '/' if present
        if ($path[0] == '/') {
            $path = substr($path, 1);
        }

        // Remove leading namespace
        $path = preg_replace('/^.*\//U', '', $path);

        return $path;
    }
}
