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
     * Link to SQLDataBase.
     *
     * @var mysqli
     */
    private ?mysqli $link = null;

    /**
     * MySql driver.
     *
     * @var mysqli_driver
     */
    private ?mysqli_driver $driver = null;

    /**
     * Query string.
     *
     * @var string
     */
    private string $query;

    /**
     * Bind parameters.
     *
     * @var string
     */
    private string $bind;

    /**
     * Values to perform operation.
     *
     * @var array mixed
     */
    private array $values;

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
        $this->query = trim($params['query']) ?? '';
        $this->bind = $params['bind'] ?? '';
        $this->values = $params['values'] ?? [];
    }

    public function __destruct()
    {
        if (!is_null($this->link)) {
            $this->link->close();
        }
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

        // Connect to DB
        $this->link->real_connect($this->host, $this->user, $this->pass, $this->name, $this->port);

        if ($this->link->connect_errno != 0) {
            throw new SQLException(ts('Error connecting to SQL Database: "%s"', $this->link->connect_error));
        }

        // Error reporting level
        $this->driver->report_mode = ENV_PRODUCTION ? MYSQLI_REPORT_OFF : MYSQLI_REPORT_ERROR;

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
     * @return int|null Affected rows
     *
     * @throws SQLException
     */
    public function import(array $params)
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
            $this->link->query($this->query);
        } else {
            // Otherwise prepared statement
            $stmt = new mysqli_stmt($this->link, $this->query);
            $stmt->bind_param($this->bind, ...$this->values);

            // Execute query
            $stmt->execute();
        }

        $affected_rows = $this->link->affected_rows;

        // Check for errors
        if ($this->link->errno != 0 || $affected_rows < 0) {
            throw new SQLException("{$this->link->error} at {$this->query}");
        }

        // Return number of affected rows
        return $affected_rows;
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
     * @return mixed Query results
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
        if ($this->link->errno != 0) {
            throw new SQLException("{$this->link->error} at {$this->query}");
        }

        return $result;
    }

    /**
     * Executes a command on the DataBase
     *
     * @param string $command Command
     *
     * @return mixed Query results
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function execute(string $command)
    {
        if (empty($command)) {
            return null;
        }

        $result = $this->link->query($command);

        // Check for errors
        if ($this->link->errno != 0) {
            throw new SQLException("{$this->link->error} at {$command}");
        }

        return $result;
    }

    /**
     * Gets auto-increment ID for last insertion
     *
     * @return int Last insert ID
     */
    public function getLastID(): int
    {
        return (int)$this->link->insert_id;
    }
}
