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

namespace Inventory\Entity\Manufacturer\DAO;

use Inventory\Core\DataBase\SQLDaO;

/**
 * Manufacturer entity DataObject
 *
 * @category DataBase
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Manufacturer extends SQLDaO
{
    /**
     * Manufacturer ID
     *
     * @var int|null
     */
    public ?int $id;

    /**
     * Manufacturer name
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * Is frequent
     *
     * @var int|null
     */
    public ?int $isFrequent;

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
    protected string $tableName = "leltar_manfac";

    /**
     * Manufacturer constructor.
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct()
    {
        parent::__construct();

        // Init fields
        $this->id = null;
        $this->name = null;
        $this->isFrequent = null;
        $this->lastModBy = null;
        $this->lastModTime = null;

        // Add metadata
        $this->addMetadata('id', 'i', 'manfac_id', 'Manufacturer ID', true);
        $this->addMetadata('name', 's', 'name', 'Manufacturer Name', true);
        $this->addMetadata('isFrequent', 'i', 'is_frequent', 'Is Frequent', true);
        $this->addMetadata('lastModBy', 's', 'last_mod_by', 'Last Modification By');
        $this->addMetadata('lastModTime', 's', 'last_mod_time', 'Last Modification Time');
    }
}
