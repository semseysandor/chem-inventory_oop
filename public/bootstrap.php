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
 * Filesystem Path to root
 */
define('ROOT', __DIR__);

/**
 * Autoloader
 */
include ROOT.'/../vendor/autoload.php';

/**
 * Few global functions
 */
include ROOT.'/global.php';

// Set error reporting level
error_reporting(E_ALL);
// error_reporting(0);

// Setting top level exception handler for any uncaught exceptions
set_exception_handler('inventory_top_level_exception_handler');
