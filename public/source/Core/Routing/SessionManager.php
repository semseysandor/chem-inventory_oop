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
 * Session Manager Class
 *
 * @category Routing
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class SessionManager
{
    /**
     * Default Timeout
     */
    protected const IDLE_TIMEOUT = 300;

    /**
     * Default Toleration Time frame for unstable networks
     */
    protected const TOLERATE_EXPIRATION = 180;

    /**
     * Timeout in sec after idle sessions will be expired
     *
     * @var int
     */
    private int $timeOut;

    /**
     * Time frame in sec until expired session are tolerated
     *
     * @var int
     */
    private int $tolerateTimeOut;

    /**
     * SessionManager constructor.
     *
     * @param int $time_out Idle timeout (s)
     * @param int $tolerate Expired session toleration (s)
     */
    public function __construct(int $time_out = null, int $tolerate = null)
    {
        $this->timeOut = $time_out ?? self::IDLE_TIMEOUT;
        $this->tolerateTimeOut = $tolerate ?? self::TOLERATE_EXPIRATION;
    }

    public function isSessionStarted(): bool
    {
        return (session_status() === PHP_SESSION_ACTIVE);
    }

    /**
     * @param int $extension
     */
    public function extendExpiration(int $extension = null)
    {
        $_SESSION['expire'] = time() + ($extension ?? self::IDLE_TIMEOUT);
    }

    /**
     * Start session
     *
     * @throws \Inventory\Core\Exception\AuthorizationException
     */
    public function startSession(): void
    {
        // Session already started
        if ($this->isSessionStarted()) {
            return;
        }

        // Session name
        session_name('id');

        // Start session
        session_start();

        // Abort script if session not loaded
        if (!$this->isSessionStarted()) {
            throw new AuthorizationException(ts('Session start failed.'));
        }

        if (isset($_SESSION['expire'])) {
            // Check if expired more than 3 minutes before
            if ($_SESSION['expire'] < (time() - $this->tolerateTimeOut)) {
                // TODO: remove_all_authentication_flag_from_active_sessions($_SESSION['user_id']);
                // throw new AuthorizationException(ts('WARNING! Expired session used.'));
                $this->regenerateSession();

                return;
            }

            // Not fully expired -> regenerated ID available
            if (isset($_SESSION['new_session_id'])) {
                // Close session
                session_commit();

                // Create new session with regenerated ID
                session_id($_SESSION['new_session_id']);
                session_start();
            }
        }
    }

    /**
     * Regenerate session
     */
    public function regenerateSession(): void
    {
        // Generate new session ID
        $new_session_id = session_create_id('chem-inv_');
        $_SESSION['new_session_id'] = $new_session_id;

        // Set expired timestamp
        $_SESSION['expire'] = time();

        // Write and close current session;
        session_commit();

        // Start session with new session ID
        session_id($new_session_id);
        ini_set('session.use_strict_mode', 0);
        session_start();
        ini_set('session.use_strict_mode', 1);

        // New session ready
        unset($_SESSION['new_session_id']);

        // Set expire time
        $this->extendExpiration();
    }
}
