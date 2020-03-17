<?php
/**
 * +---------------------------------------------------------------------+
 * | This file is part of chem-inventory.                                |
 * |                                                                     |
 * | Copyright (c) 2020 Sandor Semsey                                    |
 * | All rights reserved.                                                |
 * |                                                                     |
 * | This work is published under the MIT License.                       |
 * | https://choosealicense.com/licenses/mit/                            |
 * |                                                                     |
 * | It's a free software;)                                              |
 * |                                                                     |
 * | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 * | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 * | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 * | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 * | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 * | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 * | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 * | SOFTWARE.                                                           |
 * +---------------------------------------------------------------------+
 */

namespace Inventory\Compound\DAO\SQL;

use Inventory\Core\DataBase\SQLDaO;

/**
 * Compound entity DataObject
 *
 * @category DataBase
 * @package  Inventory
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Compound extends SQLDaO
{
    /**
     * Table name
     *
     * @var string
     */
    protected string $tableName = "leltar_compound";

    /**
     * Compound ID
     *
     * @var int|null
     */
    public ?int $id;

    /**
     * Compound name
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * Compound alternative name
     *
     * @var string|null
     */
    public ?string $nameAlt;

    /**
     * Subcategory ID
     *
     * @var int|null
     */
    public ?int $subCategory;

    /**
     * CAS number
     *
     * @var string|null
     */
    public ?string $cas;

    /**
     * Field metadata
     *
     * @var array
     */
    public array $metadata = [
      'id' => [
        'type' => 'int',
        'uniq_name' => 'compound_id',
        'required' => false,
      ],
      'name' => [
        'type' => 'string',
        'uniq_name' => 'name',
        'required' => true,
      ],
      'subCategory' => [
        'type' => 'int',
        'uniq_name' => 'sub_category_id',
        'required' => true,
      ],
      'cas' => [
        'type' => 'string',
        'uniq_name' => 'cas',
        'required' => false,
      ],
    ];

    /**
     * Compound constructor.
     */
    public function __construct()
    {
        $this->id = null;
        $this->name = null;
        $this->subCategory = null;
        $this->cas = null;

        parent::__construct();
    }
}
