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

namespace Inventory\Entity\Compound\BAO;

use Inventory\Core\DataBase\SQLDataBase;

/**
 * Compound BaO
 *
 * @category Business Layer
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Compound
{
    protected SQLDataBase $dataBase;

    /**
     * Compound constructor.
     *
     * @param \Inventory\Core\DataBase\SQLDataBase $dataBase
     */
    public function __construct(SQLDataBase $dataBase)
    {
        $this->dataBase = $dataBase;
    }

    /**
     * Gets all compounds from DataBase
     *
     * @param array|null $fields Fields to return
     *
     * @return array|null
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function getAll(array $fields = null)
    {
        $dao = new \Inventory\Entity\Compound\DAO\Compound($this->dataBase);

        $result = $dao->retrieve(
          [
            'fields' => $fields,
            'order_by' => ['name'],
          ]
        );

        return $dao->fetchResults($result);
    }
}
