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
    public function isAuthorized(): bool
    {
        // If no USER_ID -> user not logged in
        if (!isset($_SESSION['USER_ID']) || ((int)$_SESSION['USER_ID']) < 1) {
            return false;
        }

        return true;
    }

    /**
     * Authenticate user
     *
     * @param string $password Password
     * @param string $hash Hash
     *
     * @return bool
     */
    public function authenticate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Logs user in
     *
     * @param int $user_id User ID
     */
    public function logIn(int $user_id): void
    {
        $_SESSION['USER_ID'] = $user_id;
    }

    /**
     * Log out user
     */
    public function logOut(): void
    {
        // Unset session variables
        session_unset();

        // Destroy session
        session_destroy();
    }
}
