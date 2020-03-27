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

namespace Inventory\Entity\User\DAO;

use Inventory\Core\DataBase\SQLDaO;

/**
 * User entity DataObject
 *
 * @category DataBase
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class User extends SQLDaO
{
    /**
     * User ID
     *
     * @var int|null
     */
    public ?int $id;

    /**
     * User name
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * User right level
     *
     * @var int|null
     */
    public ?int $rightLevel;

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
    protected string $tableName = "main_users";

    /**
     * User constructor.
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct()
    {
        parent::__construct();

        // Init fields
        $this->id = null;
        $this->name = null;
        $this->rightLevel = null;
        $this->lastModBy = null;
        $this->lastModTime = null;

        // Add metadata
        $this->addMetadata('id', 'i', 'user_id', 'User ID', true);
        $this->addMetadata('name', 's', 'name', 'User Name', true);
        $this->addMetadata('rightLevel', 'i', 'right_level_leltar', 'Right Level', true);
        $this->addMetadata('lastModBy', 's', 'last_mod_by', 'Last Modification By');
        $this->addMetadata('lastModTime', 's', 'last_mod_time', 'Last Modification Time');
    }
}