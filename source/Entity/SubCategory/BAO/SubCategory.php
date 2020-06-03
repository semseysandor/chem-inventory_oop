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

namespace Inventory\Entity\SubCategory\BAO;

use Inventory\Core\BaseBaO;

/**
 * SubCategory Class
 *
 * @category Business Layer
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class SubCategory extends BaseBaO
{
    /**
     * Get all subcategories from DB
     *
     * @return array|null
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function getSubCategories(): ?array
    {
        $dao = $this->getDaO(\Inventory\Entity\SubCategory\DAO\SubCategory::class);

        $result = $dao->retrieve();

        return $dao->fetchResults($result);
    }
}
