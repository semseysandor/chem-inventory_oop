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

namespace Inventory\Entity\Location\DAO;

use Inventory\Core\DataBase\SQLDaO;
use Inventory\Core\DataBase\SQLDataBase;

/**
 * Location entity DataObject
 *
 * @category DataBase
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Location extends SQLDaO
{
    /**
     * Location ID
     *
     * @var int|null
     */
    public ?int $id;

    /**
     * Laboratory ID
     *
     * @var int|null
     */
    public ?int $labID;

    /**
     * Place ID
     *
     * @var int|null
     */
    public ?int $placeID;

    /**
     * Sub ID
     *
     * @var int|null
     */
    public ?int $subID;

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
    protected string $tableName = "leltar_location";

    /**
     * Location constructor.
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
        $this->labID = null;
        $this->placeID = null;
        $this->subID = null;
        $this->lastModBy = null;
        $this->lastModTime = null;

        // Add metadata
        $this->addMetadata('id', 'i', 'location_id', 'Location ID', true);
        $this->addMetadata('labID', 'i', 'loc_lab_id', 'Laboratory ID', true);
        $this->addMetadata('placeID', 'i', 'loc_place_id', 'Place ID', true);
        $this->addMetadata('subID', 'i', 'loc_sub_id', 'Sub ID', true);
        $this->addMetadata('lastModBy', 's', 'last_mod_by', 'Last Modification By');
        $this->addMetadata('lastModTime', 's', 'last_mod_time', 'Last Modification Time');
    }
}
