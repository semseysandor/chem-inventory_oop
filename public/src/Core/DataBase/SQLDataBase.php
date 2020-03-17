<?php
/**
 * +---------------------------------------------------------------------+
 * | This file is part of chem-inventory.                                |
 * |                                                                     |
 * | Copyright (c) 2020 Sandor Semsey                                    |
 * | All rights reserved.                                                |
 * |                                                                     |
 * | This work is published under the MIT License.                       |
 * | https://choosealicense.com/licenses/mit/                            |
 * |                                                                     |
 * | It's a free software;)                                              |
 * |                                                                     |
 * | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 * | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 * | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 * | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 * | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 * | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 * | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 * | SOFTWARE.                                                           |
 * +---------------------------------------------------------------------+
 */

namespace Inventory\Core\DataBase;

use Inventory\Core\Exception\FileMissing;
use Inventory\Core\Exception\SQLException;
use Inventory\Inv;
use mysqli;
use mysqli_driver;
use mysqli_stmt;

/**
 * Basic SQLDataBase operations.
 *
 * @category DataBase
 * @package  Inventory
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class SQLDataBase implements IDataBase
{
    /**
     * Singleton instance.
     *
     * @var \Inventory\Core\DataBase\SQLDataBase
     */
    private static ?SQLDataBase $instance = null;

    /**
     * Link to SQLDataBase.
     *
     * @var mysqli
     */
    private mysqli $link;

    /**
     * MySql driver.
     *
     * @var mysqli_driver
     */
    private mysqli_driver $driver;

    /**
     * Query string.
     *
     * @var string|null
     */
    private ?string $query;

    /**
     * Bind parameters.
     *
     * @var string|null
     */
    private ?string $bind;

    /**
     * Values to perform operation.
     *
     * @var array mixed
     */
    private ?array $values;

    /**
     * SQLDataBase constructor.
     *
     * @throws SQLException
     * @throws FileMissing
     */
    private function __construct()
    {
        $this->initialize();
    }

    /**
     * Make a connection to the DB.
     *
     * @return void
     *
     * @throws SQLException
     * @throws FileMissing
     */
    private function initialize(): void
    {
        // Get configs
        $db_host = Inv::settings()->getSetting('db', 'host');
        $db_user = Inv::settings()->getSetting('db', 'user');
        $db_pass = Inv::settings()->getSetting('db', 'pass');
        $db_name = Inv::settings()->getSetting('db', 'name');
        $db_port = Inv::settings()->getSetting('db', 'port');

        // Open a connection
        $this->link = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

        // If error in connection
        if ($this->link->connect_error) {
            throw new SQLException(ts('No connection to SQL Database'));
        }

        // Show errors
        // DEVELOPMENT: MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT
        // PRODUCTION: MYSQLI_REPORT_OFF
        $this->driver = new mysqli_driver();
        $this->driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

        // Set character set
        $this->link->set_charset('utf8');
    }

    /**
     * Initialize a query.
     *
     * @param array $params Query parameters
     *
     * @return void
     */
    private function initQuery(array $params): void
    {
        $this->query = $params['query'] ?? null;
        $this->bind = $params['bind'] ?? null;
        $this->values = $params['values'] ?? null;
    }

    /**
     * Singleton.
     *
     * @return $this
     *
     * @throws SQLException
     * @throws FileMissing
     */
    public static function singleton(): SQLDataBase
    {
        if (self::$instance === null) {
            self::$instance = new SQLDataBase();
        }

        return self::$instance;
    }

    /**
     * Imports data to the database.
     *
     * @param array $params Data and metadata
     *
     * @return mixed
     *
     * @throws SQLException
     */
    public function import(array $params)
    {
        // Init query
        $this->initQuery($params);

        // Check query
        if (!$this->query) {
            return null;
        }

        if (!$this->bind || !$this->values) {
            // No bind or values supplied -> simple query
            $result = $this->link->query($this->query);

            if (!$result) {
                throw new SQLException($this->query);
            }
        } else {
            // Otherwise prepared statement
            $stmt = new mysqli_stmt($this->link, $this->query);
            $stmt->bind_param($this->bind, ...$this->values);

            if (!($stmt->execute())) {
                throw new SQLException($this->query);
            }
        }

        return $this->link->affected_rows;
    }

    /**
     * Exports data from the DataBase.
     *
     * @param array $params Data and metadata
     *
     * @return mixed
     *
     * @throws SQLException
     */
    public function export(array $params)
    {
        // Init query
        $this->initQuery($params);

        // Check query
        if (!$this->query) {
            return null;
        }

        if (!$this->bind || !$this->values) {
            // No bind or values supplied -> simple query
            $result = $this->link->query($this->query);
        } else {
            // Otherwise prepared statement
            $stmt = new mysqli_stmt($this->link, $this->query);
            $stmt->bind_param($this->bind, ...$this->values);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        // Check for errors
        if (!$result) {
            throw new SQLException($this->query);
        }

        return $result;
    }

    /**
     * Executes a command on the database.
     *
     * @param array $params Data and metadata
     *
     * @return mixed|void
     */
    public function execute(array $params)
    {
        // TODO: implement execute method
    }

    /**
     * Debug function.
     *
     * @param array $params Data and metadata
     *
     * @return void
     */
    public function debug(array $params): void
    {
        $this->initQuery($params);

        $this->printQuery();
    }

    /**
     * Prints query.
     *
     * @return void
     */
    public function printQuery(): void
    {
        echo 'Query : '.$this->query."\n";
        echo 'bind  : '.$this->bind."\n";
        echo 'values: ';
        echo var_export($this->values);
    }
}
