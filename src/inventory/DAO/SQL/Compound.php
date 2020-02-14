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

namespace Inventory\DAO\SQL;

use Exception;
use Inventory\Core\SQL\QueryBuilder;

include('/home/jurkov/work/projects/chem-inventory_oop/src/bootstrap.php'); # Bootstrap
class Compound extends QueryBuilder
{
    /**
     * Compound constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getCountAll()
    {
        $result = $this->initQuerySelect(['count(compound_id) AS total'])->addFrom('leltar_compound')->execute();

        return $result->fetch_object()->total;
    }

    public function create($data)
    {
        return $this->initQueryInsert('leltar_compound', $data)->bind('si')->execute();
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function retrieve($data)
    {
        return;
        // TODO: Implement retrieve() method.
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function update($data)
    {
        // TODO: Implement update() method.
        return;
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function delete($data)
    {
        // TODO: Implement delete() method.
        return;
    }
}

class controller
{
    public function run()
    {
        try {
            $maki = new Compound();
            echo $maki->create(
              [
                'nam' => 'maki',
                'sub_category_id' => '9',

              ]
            );
        } catch (Exception $exception) {
            echo 'kakker';
            echo $exception->getMessage()."\n";
            echo $exception->getTraceAsString();
        }
    }
}

$contr = new controller();
$contr->run();
