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

    /**
     * Cleans user input string
     *
     * @param string|null $input Input string
     * @param string $mode Filtering mode (word|extended)
     *
     * @return string|null
     */
    public static function sanitizeString(?string $input, ?string $mode = 'extended')
    {
        if (is_null($input)) {
            return null;
        }

        // Trim string
        $input = trim($input);

        // Strip tags
        $input = preg_replace('/<.*>/U', '', $input);

        // Filtering
        switch ($mode) {
            case 'word':
                $pattern = '/\W/';
                break;
            case 'extended':
                $pattern = '/[^\w <>.,\-+()%]/';
                break;
            default:
                return null;
        }
        $input = preg_replace($pattern, '', $input);

        return $input;
    }

    /**
     * Sanitize ID
     *
     * @param string $id ID
     *
     * @return int|null
     */
    public static function sanitizeID(?string $id)
    {
        if (is_null($id)) {
            return null;
        }

        // Convert to integer
        $id = (int)$id;

        if ($id <= 0) {
            return null;
        }

        return $id;
    }
}
