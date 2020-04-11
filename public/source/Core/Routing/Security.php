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

namespace Inventory\Core\Routing;

use Inventory\Core\Exception\AuthorizationException;

/**
 * Security Class
 *
 * @category Routing
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Security
{
    /**
     * Initialize session
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\AuthorizationException
     */
    public function initSession(): void
    {
        // Session name
        session_name('id');

        // Start session
        session_start();

        // Abort script if session not loaded
        if (session_status() != PHP_SESSION_ACTIVE) {
            throw new AuthorizationException(ts('Session start failed.'));
        }
    }

    /**
     * Is user logged in
     *
     * @return bool
     */
    public function isAuthorized()
    {
        // If no USER_ID -> user not logged in
        if (!isset($_SESSION['USER_NAME']) || ($_SESSION['USER_NAME']) == '') {
            return false;
        }

        return true;
    }

    /**
     * Authenticate user
     */
    public function authenticate()
    {
        // TODO: implement method
    }

    /**
     * Log out user
     *
     * @return void
     */
    public function logOut(): void
    {
        // Unset session variables
        session_unset();

        // Destroy session
        session_destroy();
    }
}
