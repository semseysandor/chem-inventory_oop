<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020 Sandor Semsey                  |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

namespace Inventory\Entity\Compound\BAO;

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
        $dao = new \Inventory\Entity\Compound\DAO\Compound();

        $result = $dao->retrieve(
            [
            'fields' => $fields,
            'order_by' => ['name'],
            ]
        );

        return $dao->fetchResults($result);
    }
}
