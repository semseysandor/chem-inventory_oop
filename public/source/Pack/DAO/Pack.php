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

namespace Inventory\Pack\DAO\SQL;

use Inventory\Core\DataBase\SQLDaO;

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
     * Table name
     *
     * @var string
     */
    protected string $tableName = "leltar_pack";

    /**
     * Pack constructor.
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct()
    {
        parent::__construct();

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
