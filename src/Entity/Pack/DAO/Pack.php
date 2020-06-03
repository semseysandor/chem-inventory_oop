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

namespace Inventory\Entity\Pack\DAO;

use Inventory\Core\DataBase\SQLDaO;
use Inventory\Core\DataBase\SQLDataBase;

/**
 * Pack entity DataObject
 *
 * @category DataBase
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Pack extends SQLDaO
{
    /**
     * Table name
     *
     * @var string
     */
    public const TABLE_NAME = "leltar_pack";

    /**
     * Pack ID
     *
     * @var int|null
     */
    public ?int $id;

    /**
     * Batch ID
     *
     * @var int|null
     */
    public ?int $batchID;

    /**
     * Location ID
     *
     * @var int|null
     */
    public ?int $locationID;

    /**
     * Is original
     *
     * @var int|null
     */
    public ?int $isOriginal;

    /**
     * Pack size
     *
     * @var string|null
     */
    public ?string $size;

    /**
     * Pack weight
     *
     * @var string|null
     */
    public ?string $weight;

    /**
     * Barcode
     *
     * @var string|null
     */
    public ?string $barcode;

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
     * Pack constructor.
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
        $this->batchID = null;
        $this->locationID = null;
        $this->isOriginal = null;
        $this->size = null;
        $this->weight = null;
        $this->barcode = null;
        $this->isActive = null;
        $this->note = null;
        $this->lastModBy = null;
        $this->lastModTime = null;
        $this->tableName = self::TABLE_NAME;

        // Add metadata
        $this->addMetadata('id', 'i', 'pack_id', 'Pack ID', true);
        $this->addMetadata('batchID', 'i', 'batch_id', 'Batch ID', true);
        $this->addMetadata('locationID', 'i', 'locationID', 'Location ID', true);
        $this->addMetadata('isOriginal', 'i', 'is_original', 'Is Original', true);
        $this->addMetadata('size', 's', 'size', 'Size', true);
        $this->addMetadata('weight', 's', 'weight', 'Weight');
        $this->addMetadata('barcode', 's', 'barcode', 'Barcode');
        $this->addMetadata('isActive', 'i', 'is_active', 'Is Active', true);
        $this->addMetadata('note', 's', 'note', 'Note');
        $this->addMetadata('lastModBy', 's', 'last_mod_by', 'Last Modification By');
        $this->addMetadata('lastModTime', 's', 'last_mod_time', 'Last Modification Time');
    }
}
