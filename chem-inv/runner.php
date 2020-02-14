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

include('/home/jurkov/work/projects/chem-inventory_oop/chem-inv/bootstrap.php'); # Bootstrap
ini_set('display_errors', 0);
try {
    $maki = new Inventory\BAO\Compound();
    $data = [
      'name' => 'kutya',
      'sub_category_id' => '9',

    ];

    $maki->create();

    echo "\n";
} catch (Exception $exception) {
    echo "kakker\n";
    echo $exception->getMessage();
    // echo $exception->getTraceAsString();
}
