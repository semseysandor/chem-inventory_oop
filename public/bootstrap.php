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

// Strict typing
declare(strict_types=1);

// Filesystem Path to root
const ROOT = __DIR__.'/..';

// Environment
const ENV_PRODUCTION = true;

// Autoloader
include ROOT.'/vendor/autoload.php';

// Set error reporting level
error_reporting((ENV_PRODUCTION ? 0 : E_ALL));

/**
 * Translate function
 *
 * @param string $string String to translate
 * @param array $params Parameters
 *
 * @return string Translated string
 */
function ts(string $string, ...$params): string
{
    // If simple string
    if (empty($params)) {
        return $string;
    }

    // There are other params -> formatted
    return sprintf($string, ...$params);
}
