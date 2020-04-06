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

/**
 * DataBase Interface.
 *
 * @category Database
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
interface IDataBase
{
    /**
     * Imports data to the DataBase.
     *
     * @param array $params Data and metadata for importing
     *
     * @return mixed
     */
    public function import(array $params);

    /**
     * Exports data from the DataBase.
     *
     * @param array $params Data and metadata for exporting
     *
     * @return mixed
     */
    public function export(array $params);
}
