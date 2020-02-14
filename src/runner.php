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

use Inventory\DAO\SQL\Compound;

include('/home/jurkov/work/projects/chem-inventory_oop/src/bootstrap.php'); # Bootstrap
try {
    $maki = new Compound();
    $data = [
      'name' => 'kutya',
      'sub_category_id' => '9',

    ];
    echo $maki->getCountAll()."\n";
    $maki->create($data);
    echo $maki->getCountAll();
} catch (Exception $exception) {
    echo 'kakker';
    echo $exception->getMessage()."\n";
    echo $exception->getTraceAsString();
}
