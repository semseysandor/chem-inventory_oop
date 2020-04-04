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

namespace Inventory\Core\Routing;

use Inventory\Core\Exception\InvalidRequest;

/**
 * Request Class
 *
 * @category Routing
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Request
{
    /**
     * Parse GET & POST data
     *
     * @return array|null
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function parseData()
    {
        // Check for request method
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            throw new InvalidRequest(ts('Missing request method.'));
        }

        // Check allowed request methods
        if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
            throw new InvalidRequest(ts('Not supported request method "%s".', $_SERVER['REQUEST_METHOD']));
        }

        // Return request data
        return ($_REQUEST ?? null);
    }

    /**
     * Parse route
     *
     * @return array
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function parseRoute(): array
    {
        // Check for request URI
        if (!isset($_SERVER['REQUEST_URI'])) {
            throw new InvalidRequest(ts('Missing request URI.'));
        }
        if (!is_string($_SERVER['REQUEST_URI'])) {
            throw new InvalidRequest(ts('Invalid request URI.'));
        }

        // Extract route from request URL
        $route = explode('/', $_SERVER['REQUEST_URI']);

        // Push delimiter out of array '/'
        if (count($route) > 0) {
            array_shift($route);
        }

        return $route;
    }
}
