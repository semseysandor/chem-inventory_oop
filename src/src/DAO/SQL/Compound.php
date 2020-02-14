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

use Inventory\Core\SQL\QueryBuilder;

include('/home/jurkov/work/projects/chem-inventory_oop/src/bootstrap.php'); # Bootstrap
class Compound extends QueryBuilder
{
    public function getCountAll()
    {
        $result = $this->retrieve(['count(compound_id) AS total'])->addFrom('leltar_compound')->execute();

        return $result->fetch_object()->total;
    }
}

$maki = new Compound();
echo $maki->getCountAll();
