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

namespace Inventory\Entity\Batch\DAO;

use Inventory\Core\DataBase\SQLDaO;
use Inventory\Core\DataBase\SQLDataBase;

/**
 * Batch entity DataObject
 *
 * @category DataBase
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Batch extends SQLDaO
{
    /**
     * Table name
     *
     * @var string
     */
    public const TABLE_NAME = "leltar_batch";

    /**
     * Batch ID
     *
     * @var int|null
     */
    public ?int $id;

    /**
     * Compound ID
     *
     * @var int|null
     */
    public ?int $compID;

    /**
     * Manufacturer ID
     *
     * @var int|null
     */
    public ?int $manfacID;

    /**
     * Batch name
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * LOT number
     *
     * @var string|null
     */
    public ?string $lot;

    /**
     * Date arrived
     *
     * @var string|null
     */
    public ?string $dateArr;

    /**
     * Date opened
     *
     * @var string|null
     */
    public ?string $dateOpen;

    /**
     * Date expired
     *
     * @var string|null
     */
    public ?string $dateExp;

    /**
     * Date archived
     *
     * @var string|null
     */
    public ?string $dateArch;

    /**
     * Is active
     *
     * @var int|null
     */
    public ?int $isActive;

    /**
     * Note
     *
     * @var string|null
     */
    public ?string $note;

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
     * Batch constructor.
     *
     * @param \Inventory\Core\DataBase\SQLDataBase $dataBase DataBase
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct(SQLDataBase $dataBase)
    {
        parent::__construct($dataBase);

        // Init fields
        $this->id = null;
        $this->compID = null;
        $this->manfacID = null;
        $this->name = null;
        $this->lot = null;
        $this->dateArr = null;
        $this->dateOpen = null;
        $this->dateExp = null;
        $this->dateArch = null;
        $this->isActive = null;
        $this->note = null;
        $this->lastModBy = null;
        $this->lastModTime = null;
        $this->tableName = self::TABLE_NAME;

        // Add metadata
        $this->addMetadata('id', 'i', 'batch_id', 'Batch ID', true);
        $this->addMetadata('compID', 'i', 'compound_id', 'Compound ID', true);
        $this->addMetadata('manfacID', 'i', 'manfac_id', 'Manufacturer ID', true);
        $this->addMetadata('name', 's', 'name', 'Batch Name', true);
        $this->addMetadata('lot', 's', 'lot', 'LOT number', true);
        $this->addMetadata('dataArr', 's', 'date_arr', 'Date Arrive', true);
        $this->addMetadata('dateOpen', 's', 'date_open', 'Date Opened');
        $this->addMetadata('dateExp', 's', 'date_exp', 'Date Expired');
        $this->addMetadata('dateArch', 's', 'date_arch', 'Date Archived');
        $this->addMetadata('isActive', 'i', 'is_active', 'Is Active', true);
        $this->addMetadata('note', 's', 'note', 'Note');
        $this->addMetadata('lastModBy', 's', 'last_mod_by', 'Last Modification By');
        $this->addMetadata('lastModTime', 's', 'last_mod_time', 'Last Modification Time');
    }
}
