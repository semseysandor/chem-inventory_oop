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
     * Session Manager
     *
     * @var \Inventory\Core\Routing\SessionManager
     */
    protected SessionManager $sessionManager;

    /**
     * Security constructor.
     *
     * @param \Inventory\Core\Routing\SessionManager $session_manager
     */
    public function __construct(SessionManager $session_manager)
    {
        $this->sessionManager = $session_manager;
    }

    /**
     * Is user logged in
     *
     * @return bool
     *
     * @throws \Inventory\Core\Exception\AuthorizationException
     */
    public function isAuthenticated(): bool
    {
        // Start session
        $this->sessionManager->startSession();

        // If no USER_ID -> user logged in
        if (!isset($_SESSION['AUTH']) || $_SESSION['AUTH'] !== true) {
            return false;
        }

        // User authenticated -> give more time
        $_SESSION['expired'] = time() + 300;

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
     * @param string $user_name User name
     */
    public function logIn(int $user_id, string $user_name): void
    {
        // Regenerate session
        $this->sessionManager->regenerateSession();

        // Set authentication flag & user name
        $_SESSION['AUTH'] = true;
        $_SESSION['USER_ID'] = $user_id;
        $_SESSION['USER_NAME'] = $user_name;
    }

    /**
     * Log out user
     */
    public function logOut(): void
    {
        unset($_SESSION['AUTH']);
        unset($_SESSION['USER_ID']);
        unset($_SESSION['USER_NAME']);
        $this->sessionManager->regenerateSession();
    }
}
