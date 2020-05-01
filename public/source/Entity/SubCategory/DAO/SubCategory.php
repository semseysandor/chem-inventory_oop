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

namespace Inventory\Entity\SubCategory\DAO;

use Inventory\Core\DataBase\SQLDaO;
use Inventory\Core\DataBase\SQLDataBase;

/**
 * SubCategory entity DataObject
 *
 * @category DataBase
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class SubCategory extends SQLDaO
{
    /**
     * SubCategory ID
     *
     * @var int|null
     */
    public ?int $id;

    /**
     * Category ID
     *
     * @var int|null
     */
    public ?int $categoryID;

    /**
     * SubCategory name
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * Last modification by
     *
     * @var string|null
     */
    public ?string $lastModBy;

    /**
     * Last modification time
     *
     * @var string|null
     */
    public ?string $lastModTime;

    /**
     * Table name
     *
     * @var string
     */
    public const TABLE_NAME = "leltar_sub_category";

    /**
     * SubCategory constructor.
     *
     * @param \Inventory\Core\DataBase\SQLDataBase $dataBase
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct(SQLDataBase $dataBase)
    {
        parent::__construct($dataBase);

        // Init fields
        $this->id = null;
        $this->categoryID = null;
        $this->name = null;
        $this->lastModBy = null;
        $this->lastModTime = null;
        $this->tableName = self::TABLE_NAME;

        // Add metadata
        $this->addMetadata('id', 'i', 'sub_category_id', 'SubCategory ID', true);
        $this->addMetadata('categoryID', 'i', 'category_id', 'Category ID', true);
        $this->addMetadata('name', 's', 'name', 'SubCategory Name', true);
        $this->addMetadata('lastModBy', 's', 'last_mod_by', 'Last Modification By');
        $this->addMetadata('lastModTime', 's', 'last_mod_time', 'Last Modification Time');
    }
}
