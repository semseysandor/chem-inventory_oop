<?php
/**
 +---------------------------------------------------------------------+
 | This file is part of chem-inventory.                                |
 |                                                                     |
 | Copyright (c) 2020 Sandor Semsey                                    |
 | All rights reserved.                                                |
 |                                                                     |
 | This work is published under the MIT License.                       |
 | https://choosealicense.com/licenses/mit/                            |
 |                                                                     |
 | It's a free software;)                                              |
 |                                                                     |
 | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 | SOFTWARE.                                                           |
 +---------------------------------------------------------------------+
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
    public static function initSession(): void
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
    public static function isAuthorized()
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
    public static function authenticate()
    {
        // TODO: implement method
    }

    /**
     * Log out user
     *
     * @return void
     */
    public static function logOut(): void
    {
        // Unset session variables
        session_unset();

        // Destroy session
        session_destroy();
    }
}
