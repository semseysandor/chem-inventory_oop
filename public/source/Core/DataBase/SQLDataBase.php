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

namespace Inventory\Core\DataBase;

use Inventory\Core\Exception\SQLException;
use Inventory\Core\Settings;
use mysqli;
use mysqli_driver;
use mysqli_stmt;

/**
 * Basic SQLDataBase operations.
 *
 * @category DataBase
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class SQLDataBase implements IDataBase
{
    /**
     * Error reporting
     *
     * Development = true
     * Production  = false
     */
    private const ERROR_REPORTING = true;

    /**
     * Link to SQLDataBase.
     *
     * @var mysqli
     */
    private ?mysqli $link;

    /**
     * MySql driver.
     *
     * @var mysqli_driver
     */
    private ?mysqli_driver $driver;

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
     */
    public function __construct()
    {
        $this->link = null;
        $this->driver = null;
        $this->query = null;
        $this->bind = null;
        $this->values = null;
    }

    /**
     * Make a connection to the DataBase.
     *
     * @param \Inventory\Core\Settings $settings
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function initialize(Settings $settings): void
    {
        // Get configs
        $db_host = $settings->getSetting('db', 'host');
        $db_user = $settings->getSetting('db', 'user');
        $db_pass = $settings->getSetting('db', 'pass');
        $db_name = $settings->getSetting('db', 'name');
        $db_port = $settings->getSetting('db', 'port');

        // Open a connection
        $this->link = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

        // If error in connection
        if ($this->link->connect_error) {
            throw new SQLException(ts('No connection to SQL Database'));
        }

        // Error reporting level
        $this->driver = new mysqli_driver();
        $this->driver->report_mode = self::ERROR_REPORTING ? MYSQLI_REPORT_ERROR : MYSQLI_REPORT_OFF;

        // Set character set
        $this->link->set_charset('utf8');
    }

    /**
     * Initialize a query.
     *
     * @param array $params Query parameters
     * $params =
     *   [
     *    query  => 'query string'
     *    bind   => 'sii'
     *    values => [value_1, value_2, value_3]
     *   ]
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
     * Imports data to the DataBase.
     *
     * @param array $params Data and metadata
     * $params =
     *   [
     *    query  => 'query string'
     *    bind   => 'sii'
     *    values => [value_1, value_2, value_3]
     *   ]
     *
     * @return int
     *
     * @throws SQLException
     */
    public function import(array $params): int
    {
        // Init query
        $this->initQuery($params);

        // Check query
        if (empty($this->query)) {
            return null;
        }

        // No bind or values supplied -> simple query
        if (empty($this->bind) || empty($this->values)) {
            // Execute query
            $result = $this->link->query($this->query);

            // Check results
            if (!$result) {
                throw new SQLException($this->query);
            }

            // Return number of affected rows
            return $this->link->affected_rows;
        }

        // Otherwise prepared statement
        $stmt = new mysqli_stmt($this->link, $this->query);
        $stmt->bind_param($this->bind, ...$this->values);

        // Execute query and check for results
        if (!($stmt->execute())) {
            throw new SQLException($this->query);
        }

        // Return number of affected rows
        return $this->link->affected_rows;
    }

    /**
     * Exports data from the DataBase.
     *
     * @param array $params Data and metadata
     * $params =
     *   [
     *    query  => 'query string'
     *    bind   => 'sii'
     *    values => [value_1, value_2, value_3]
     *   ]
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
        if (empty($this->query)) {
            return null;
        }

        if (empty($this->bind) || empty($this->values)) {
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
     * Gets auto-increment ID for last insertion
     *
     * @return int
     */
    public function getLastID(): int
    {
        return (int)$this->link->insert_id;
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
