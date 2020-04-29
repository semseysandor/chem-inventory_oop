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

use Inventory\Core\BaseBaO;
use Inventory\Core\Containers\Service;
use Inventory\Entity\SubCategory\DAO\SubCategory;

/**
 * Compound BaO
 *
 * @category Business Layer
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Compound extends BaseBaO
{
    /**
     * BaseBAO constructor.
     *
     * @param \Inventory\Core\Containers\Service $service
     */
    public function __construct(Service $service)
    {
        parent::__construct($service);
        $this->daoClass = \Inventory\Entity\Compound\DAO\Compound::class;
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
    public function getAll(array $fields = null): ?array
    {
        $params =
            [
                'fields' => $fields,
                'order_by' => ['name'],
            ];

        return $this->retrieve($params);
    }

    /**
     * Get all compound in given category
     *
     * @param int $category_id
     * @param array|null $fields
     *
     * @return array|null
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function getCategoryCompound(int $category_id, array $fields = null): ?array
    {
        // Get related DaO
        $subcategory = $this->getDaO(SubCategory::class);
        $compound = $this->getDaO(\Inventory\Entity\Compound\DAO\Compound::class);

        // Query parameters
        $params =
            [
                'fields' => $fields,
                'join' => [[$subcategory->getTableName(), 'sub_category_id']],
                'where' => [['category_id', '=', $category_id]],
                'order_by' => ["{$compound->getTableName()}.name"],
            ];

        return $this->retrieve($params);
    }
}
