<?php
/**
 +---------------------------------------------------------------------+
 | This file is part of chem-inventory.                                |
 |                                                                     |
 | Copyright (c) 2020 Sandor Semsey                                    |
 | All rights reserved.                                                |
 |                                                                     |
 | This work is published under the MIT License.                       |
 | https://choosealicense.com/licenses/mit/                            |
 |                                                                     |
 | It's a free software;)                                              |
 |                                                                     |
 | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 | SOFTWARE.                                                           |
 +---------------------------------------------------------------------+
 */

namespace Inventory\Category\DAO;

use Inventory\Core\DataBase\SQLDaO;

/**
 * Location entity DataObject
 *
 * @category DataBase
 * @package  Inventory
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
     * Last Modification By
     *
     * @var string|null
     */
    public ?string $lastModBy;

    /**
     * Last Modification Time
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
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct()
    {
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

        parent::__construct();
    }
}
