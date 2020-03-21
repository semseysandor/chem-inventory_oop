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

namespace Inventory\Entity\Batch\DAO;

use Inventory\Core\DataBase\SQLDaO;

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
     * Table name
     *
     * @var string
     */
    protected string $tableName = "leltar_batch";

    /**
     * Batch constructor.
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct()
    {
        parent::__construct();

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
