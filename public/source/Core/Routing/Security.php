<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | (c) Sandor Semsey <semseysandor@gmail.com>    |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 |                                               |
 | It's a free software;)                        |
 +-----------------------------------------------+
 */

/**
 * +-----------------------------------------------+
 * | This file is part of chem-inventory.          |
 * |                                               |
 * | (c) Sandor Semsey <semseysandor@gmail.com>    |
 * | All rights reserved.                          |
 * |                                               |
 * | This work is published under the MIT License. |
 * | https://choosealicense.com/licenses/mit/      |
 * |                                               |
 * | It's a free software;)                        |
 * +-----------------------------------------------+
 */

namespace Inventory\Core\Routing;

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
     */
    public function initSession(): void
    {
        // Start session
        session_start();

        // Abort script if session not loaded
        if (session_status() != PHP_SESSION_ACTIVE) {
            exit(ts('Session start failed.'));
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
