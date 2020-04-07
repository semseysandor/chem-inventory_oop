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

use Exception;
use Inventory\Core\Exception\SQLException;
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
     * DataBase host
     *
     * @var string
     */
    private string $host;

    /**
     * DataBase port
     *
     * @var int
     */
    private int $port;

    /**
     * DataBase name
     *
     * @var string
     */
    private string $name;

    /**
     * DataBase user
     *
     * @var string
     */
    private string $user;

    /**
     * DataBase password
     *
     * @var string
     */
    private string $pass;

    /**
     * SQLDataBase constructor.
     *
     * @param string $host DB host
     * @param int $port DB port
     * @param string $name DB name
     * @param string $user DB user
     * @param string $pass DB pass
     */
    public function __construct(string $host, int $port, string $name, string $user, string $pass)
    {
        $this->host = $host;
        $this->port = $port;
        $this->name = $name;
        $this->user = $user;
        $this->pass = $pass;
        $this->link = null;
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
     */
    private function initQuery(array $params): void
    {
        $this->query = trim($params['query']) ?? null;
        $this->bind = $params['bind'] ?? null;
        $this->values = $params['values'] ?? null;
    }

    /**
     * Connects to the DataBase
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function connect(): void
    {
        // Init link
        $this->link = mysqli_init();
        $this->driver = new mysqli_driver();

        try {
            // Connect to DB
            $this->link->real_connect($this->host, $this->user, $this->pass, $this->name, $this->port);
        } catch (Exception $ex) {
            throw new SQLException(ts('Error connecting to SQL Database: "%s"', $this->link->connect_error));
        }

        // Error reporting level
        $this->driver->report_mode = self::ERROR_REPORTING ? MYSQLI_REPORT_ERROR : MYSQLI_REPORT_OFF;

        // Set character set
        $this->link->set_charset('utf8');
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
     * @return int|null
     *
     * @throws SQLException
     */
    public function import(array $params)
    {
        try {
            // Init query
            $this->initQuery($params);

            // Check query
            if (empty($this->query)) {
                return null;
            }

            // No bind or values supplied -> simple query
            if (empty($this->bind) || empty($this->values)) {
                // Execute query
                $this->link->query($this->query);
            } else {
                // Otherwise prepared statement
                $stmt = new mysqli_stmt($this->link, $this->query);
                $stmt->bind_param($this->bind, ...$this->values);

                // Execute query
                $stmt->execute();
            }

            // Return number of affected rows
            return $this->link->affected_rows;
        } catch (Exception $ex) {
            throw new SQLException($ex->getMessage());
        }
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
        try {
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

            return $result;
        } catch (Exception $ex) {
            throw new SQLException($this->query);
        }
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
}
