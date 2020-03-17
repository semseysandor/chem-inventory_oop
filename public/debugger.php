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

// Bootstrap
use Inventory\Compound\DAO\SQL\Compound;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Exception\InventoryException;

require 'bootstrap.php';
ini_set('display_errors', '0');
// var_export(ini_get_all());
try {
    $maki = new Compound();
    $data = [
      'fields' => ['id', 'name'],
      'where' => [
        ['id', '>', '?'],
      ],
      'values' => [746],
        // 'limit' => '2',
        // 'offset' => '50',
        // 'order_by' => ['majom','kutya'],

    ];

    $res = $maki->retrieveRecord(747);
    while ($row = $res->fetch_assoc()) {
        var_export($row);
    }

    $maki->name = 'beco5';
    $maki->id = 747;
    echo var_export($maki->update());
    echo "\n";

    $res = $maki->retrieve($data);
    while ($row = $res->fetch_assoc()) {
        var_export($row);
    }
    throw new BadArgument('debugger');
} catch (InventoryException $ex) {
    $ex->print();
}
