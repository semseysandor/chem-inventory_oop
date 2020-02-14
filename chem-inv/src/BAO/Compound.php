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

namespace Inventory\BAO;

class Compound
{
    public function create()
    {
        $name = 'manki';
        $subcat = 9;
        $cas = '123';

        $dao = new \Inventory\DAO\SQL\Compound();

        echo $dao->getCountAll();
        echo "\n";
        $dao->create(
          [
            'name' => $name,
            'sub_category_id' => $subcat,
            'cas' => $cas,

          ]
        );

        echo $dao->getCountAll();
    }
}
