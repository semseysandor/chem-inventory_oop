<?php
/**
 * This file is part of chem-inventory.
 * Written by Sandor Semsey.
 *
 * Copyright (c) 2020.
 * This is work licenced under the GNU General Public License v3.0. All rights reserved.
 *
 * This is a free software;)
 */

namespace Inventory\Core;
include('/home/jurkov/work/projects/chem-inventory_oop/src/bootstrap.php'); # Bootstrap
use mysqli;
use mysqli_driver;

class SQLDataBase implements IDataBase
{
    /**
     * Link to database
     *
     * @var mysqli
     */
    private $link;

    /**
     * SQLDataBase constructor.
     *
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * @inheritDoc
     */
    private function initialize(): void
    {
        // Open a link to the database
        $dbHost = Configurator::singleton()->getConfig('DB_host');
        $dbUser = Configurator::singleton()->getConfig('DB_user');
        $dbPass = Configurator::singleton()->getConfig('DB_pass');
        $dbName = Configurator::singleton()->getConfig('DB_name');
        $dbPort = Configurator::singleton()->getConfig('DB_port');

        $this->link = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

        // If error in connection
        if ($this->link->connect_error) {
            throw new leltar_exception('no_conn_db', 1);
        }

        //Show all errors: DEVELOPMENT ONLY
        //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        // Don't show errors: PRODUCTION ONLY
        $driver = new mysqli_driver;
        $driver->report_mode = MYSQLI_REPORT_OFF;

        // Set character set
        $this->link->set_charset('utf8');
    }

    /**
     * @inheritDoc
     */
    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    /**
     * @inheritDoc
     */
    public function retrieve(array $what)
    {
        if ($what['bind'] == null || $what['data'] == null) {
            $result = $this->link->query($what['query']);
        } else {
            $stmt = $this->link->prepare($what['query']);
            $stmt->bind_param($what['bind'], ...$what['data']);
            $stmt->execute();

            $result = $stmt->get_result();

            $stmt->close();
        }

        if (!$result) {
            throw new leltar_exception('sql_fail', 1);
        }

        return $result;
    }
}

$sql = '
	SELECT
		leltar_manfac.manfac_id AS id,
		leltar_manfac.name
	FROM leltar_manfac
	WHERE leltar_manfac.is_frequent = 1
	ORDER BY leltar_manfac.name
	';
$data = [
  'query' => $sql,
  'bind' => '',
  'data' => [],
];
$majom = new SQLDataBase();
var_dump($majom->retrieve($data));
