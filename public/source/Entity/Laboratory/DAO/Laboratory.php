<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | (c) Sandor Semsey <semseysandor@gmail.com>    |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 |                                               |
 | It's a free software;)                        |
 +-----------------------------------------------+
 */

/**
 * +-----------------------------------------------+
 * | This file is part of chem-inventory.          |
 * |                                               |
 * | (c) Sandor Semsey <semseysandor@gmail.com>    |
 * | All rights reserved.                          |
 * |                                               |
 * | This work is published under the MIT License. |
 * | https://choosealicense.com/licenses/mit/      |
 * |                                               |
 * | It's a free software;)                        |
 * +-----------------------------------------------+
 */

namespace Inventory\Entity\Laboratory\DAO;

use Inventory\Core\DataBase\SQLDaO;

/**
 * Laboratory entity DataObject
 *
 * @category DataBase
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Laboratory extends SQLDaO
{
    /**
     * Laboratory ID
     *
     * @var int|null
     */
    public ?int $id;

    /**
     * Laboratory name
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
    protected string $tableName = "leltar_loc_lab";

    /**
     * Laboratory constructor.
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct()
    {
        parent::__construct();

        // Init fields
        $this->id = null;
        $this->name = null;
        $this->lastModBy = null;
        $this->lastModTime = null;

        // Add metadata
        $this->addMetadata('id', 'i', 'loc_lab_id', 'Laboratory ID', true);
        $this->addMetadata('name', 's', 'name', 'Laboratory Name', true);
        $this->addMetadata('lastModBy', 's', 'last_mod_by', 'Last Modification By');
        $this->addMetadata('lastModTime', 's', 'last_mod_time', 'Last Modification Time');
    }
}
