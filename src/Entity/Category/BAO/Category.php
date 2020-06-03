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

namespace Inventory\Entity\Category\BAO;

use Inventory\Core\BaseBaO;

/**
 * Category BAO Class
 *
 * @category Business Layer
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Category extends BaseBaO
{
    /**
     * Get all categories from DB
     *
     * @return array|null
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function getCategories(): ?array
    {
        $dao = $this->getDaO(\Inventory\Entity\Category\DAO\Category::class);

        $result = $dao->retrieve();

        return $dao->fetchResults($result);
    }
}
