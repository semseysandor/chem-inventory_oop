<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | (c) Sandor Semsey <semseysandor@gmail.com>    |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 |                                               |
 | It's a free software;)                        |
 +-----------------------------------------------+
 */

/**
 * +-----------------------------------------------+
 * | This file is part of chem-inventory.          |
 * |                                               |
 * | (c) Sandor Semsey <semseysandor@gmail.com>    |
 * | All rights reserved.                          |
 * |                                               |
 * | This work is published under the MIT License. |
 * | https://choosealicense.com/licenses/mit/      |
 * |                                               |
 * | It's a free software;)                        |
 * +-----------------------------------------------+
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

    /**
     * Executes a command on the DataBase.
     *
     * @param array $params Command and metadata
     *
     * @return mixed
     */
    public function execute(array $params);
}
