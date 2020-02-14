<?php
/**
 * This file is part of chem-inventory.
 * Written by Sandor Semsey.
 *
 * Copyright (c)  2020.
 * This is work licenced under the GNU General Public License v3.0. All rights reserved.
 *
 * This is a free software;)
 */

namespace Inventory\Core\SQL;

use Exception;
use Inventory\Core\Configurator;
use mysqli;
use mysqli_driver;
use mysqli_sql_exception;

/**
 * Basic DataBase operations
 *
 * @package Inventory\Core\SQL
 */
class DataBase
{
    /**
     * General error message
     */
    const SQL_FAIL = 'SQL query failed!';

    /**
     * Connection failed error message
     */
    const NO_CONN = 'No connection to DataBase!';

    /**
     * @var mysqli Link to DataBase
     */
    protected $link;

    /**
     * @var mysqli_driver MySQL Driver
     */
    protected $driver;

    /**
     * DataBase constructor
     */
    protected function __construct()
    {
        $this->initialize();
    }

    /**
     * Make a connection to the DB
     *
     * @throws \Exception
     */
    protected function initialize(): void
    {
        $dbHost = Configurator::singleton()->getConfig('DB_host');
        $dbUser = Configurator::singleton()->getConfig('DB_user');
        $dbPass = Configurator::singleton()->getConfig('DB_pass');
        $dbName = Configurator::singleton()->getConfig('DB_name');
        $dbPort = Configurator::singleton()->getConfig('DB_port');

        // Open a connection
        $this->link = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

        // If error in connection
        if ($this->link->connect_error) {
            throw new mysqli_sql_exception(self::NO_CONN);
        }

        // Show errors
        // DEVELOPMENT: MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT
        // PRODUCTION: MYSQLI_REPORT_OFF
        $this->driver = new mysqli_driver;
        $this->driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

        // Set character set
        $this->link->set_charset('utf8');
    }

    /**
     * Executes a query on DataBase
     *
     * @param string $query Query to execute
     * @param bool $select true is select false if other (insert, delete, update)
     * @param string|null $bind Variable types string
     * @param array|null $data Data
     *
     * @return mixed Number of affected rows | Data | null
     * @throws \Exception
     */
    protected function executeQuery(string $query, bool $select = true, string $bind = null, array $data = null)
    {
        if ($query == null) {
            return null;
        }

        // Simple query
        if ($bind == null || $data == null) {
            $result = $this->link->query($query);

            if (!$result) {
                throw new Exception(self::SQL_FAIL);
            }

            if ($select) {
                return $result;
            } else {
                return $this->link->affected_rows;
            }
        }

        // Prepared statement
        $stmt = $this->link->prepare($query);
        $stmt->bind_param($bind, ...$data);

        if ($select) {
            $stmt->execute();

            $result = $stmt->get_result();

            if (!$result) {
                throw new Exception(self::SQL_FAIL);
            }

            return $result;
        } else {
            if (!($stmt->execute())) {
                throw new Exception(self::SQL_FAIL);
            }

            return $this->link->affected_rows;
        }
    }
}
