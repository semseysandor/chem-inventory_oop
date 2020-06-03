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
     * @return array|null
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function getAll(): ?array
    {
        // Table name
        $compound_table = \Inventory\Entity\Compound\DAO\Compound::TABLE_NAME;

        $params =
            [
                'fields' => [
                    "{$compound_table}.compound_id",
                    "{$compound_table}.name",
                    "{$compound_table}.name_alt",
                    "{$compound_table}.abbrev",
                    "{$compound_table}.note",
                ],
                'order_by' => ['name'],
            ];

        return $this->retrieve($params);
    }

    /**
     * Get all compound in given category
     *
     * @param int $category_id Category ID
     *
     * @return array|null
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function getCategoryCompound(int $category_id): ?array
    {
        // Table name
        $compound_table = \Inventory\Entity\Compound\DAO\Compound::TABLE_NAME;
        $subcategory_table = SubCategory::TABLE_NAME;

        // Query parameters
        $params =
            [
                'fields' => [
                    "{$compound_table}.compound_id",
                    "{$compound_table}.name",
                    "{$compound_table}.name_alt",
                    "{$compound_table}.abbrev",
                    "{$compound_table}.note",
                ],
                'join' => [[$subcategory_table, 'sub_category_id']],
                'where' => [['category_id', '=', $category_id]],
                'order_by' => ["'{$subcategory_table}.name'"],
            ];

        return $this->retrieve($params);
    }

    /**
     * Get all compound in given subcategory
     *
     * @param int $sub_category_id Sub-category ID
     *
     * @return array|null
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function getSubCategoryCompound(int $sub_category_id): ?array
    {
        // Table name
        $compound_table = \Inventory\Entity\Compound\DAO\Compound::TABLE_NAME;

        // Query parameters
        $params =
            [
                'fields' => [
                    "{$compound_table}.compound_id",
                    "{$compound_table}.name",
                    "{$compound_table}.name_alt",
                    "{$compound_table}.abbrev",
                    "{$compound_table}.note",
                ],
                'where' => [['sub_category_id', '=', $sub_category_id]],
                'order_by' => ["{$compound_table}.name"],
            ];

        return $this->retrieve($params);
    }

    /**
     * Insert new compound
     *
     * @param array $data Fields and values
     *
     * @return mixed
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\FieldMissing
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function insertCompound(array $data)
    {
        $fields = [];
        $dao = $this->getDaO(\Inventory\Entity\Compound\DAO\Compound::class);

        // Parse data and load to DaO
        foreach ($data as $key => $item) {
            array_push($fields, $key);
            $dao->$key = $item;
        }

        // Insert compound
        return $dao->initInsert()->setInsert($fields)->execute();
    }
}
