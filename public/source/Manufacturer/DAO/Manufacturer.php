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

namespace Inventory\Manufacturer\DAO;

use Inventory\Core\DataBase\SQLDaO;

/**
 * Manufacturer entity DataObject
 *
 * @category DataBase
 * @package  Inventory
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
     * Manufacturer Name
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * Is Frequent
     *
     * @var int|null
     */
    public ?int $isFrequent;

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
    protected string $tableName = "leltar_manfac";

    /**
     * Manufacturer constructor.
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct()
    {
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

        parent::__construct();
    }
}
