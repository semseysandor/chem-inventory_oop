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

/**
 * Category BAO Class
 *
 * @category Business Layer
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Category extends \Inventory\Core\BaseBaO
{
    public function getCategories(): ?array
    {
        $dao = $this->getDaO(\Inventory\Entity\Category\DAO\Category::class);

        $result = $dao->retrieve();

        return $dao->fetchResults($result);
    }

}
