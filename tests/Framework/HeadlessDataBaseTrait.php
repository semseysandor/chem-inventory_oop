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

namespace Inventory\Test\Framework;

use mysqli;

/**
 * Headless DataBase
 * Trait to access a headless DataBase
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
trait HeadlessDataBaseTrait
{
    /**
     * Host name
     *
     * @var string
     */
    protected string $host = 'localhost';

    /**
     * Port
     *
     * @var int
     */
    protected int $port = 3306;

    /**
     * DataBase name
     *
     * @var string
     */
    protected string $name = 'test';

    /**
     * User name
     *
     * @var string
     */
    protected string $user = 'admin';

    /**
     * Pass
     *
     * @var string
     */
    protected string $pass = 'admin';

    /**
     * Connects to test DataBase
     *
     * @return \mysqli
     */
    protected function connectDB(): mysqli
    {
        return new mysqli($this->host, $this->user, $this->pass, $this->name, $this->port);
    }

    /**
     * Truncates test DataBase table
     */
    protected function truncateTestDB()
    {
        $link = $this->connectDB();
        $link->query("TRUNCATE TABLE test_table");
    }
}
