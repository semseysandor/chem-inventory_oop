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

/**
 * Top level exception handler
 *
 * @param \Exception $ex Exception to handle
 */
function toplevel($ex)
{
    header('Content-Type: text; charset=UTF-8');
    echo "FATAL ERROR!\n\n";
    echo $ex->getMessage()."\n\n";
    echo $ex->getTraceAsString();
}

/**
 * Translate function
 *
 * @param string $string String to translate
 * @param array $params
 *
 * @return string
 */
function ts(string $string, ...$params)
{
    // If simple string
    if (empty($params)) {
        return $string;
    }

    // There are other params -> formatted
    return sprintf($string, ...$params);
}
