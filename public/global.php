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
function inventory_top_level_exception_handler($ex)
{
    $message = $ex->getMessage();
    $trace = $ex->getTraceAsString();

    if (!headers_sent()) {
        // Console type response
        header('Content-Type: text; charset=UTF-8');
        echo "FATAL ERROR!\n\n";
        echo $message."\n\n";
        echo $trace;
    } else {
        // HTML type response
        echo "<div><h1>Fatal Error</h1>";
        echo "<p>".$message."</p>";
        echo "<p>".$trace."</p></div>";
    }
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
