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

namespace Inventory\Compound\BAO;

/**
 * Compound BaO
 *
 * @category Business Layer
 * @package  Inventory
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Compound
{
    /**
     * Gets all compounds from DataBase
     *
     * @return array|null
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\FileMissing
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function getAll()
    {
        // TODO: experimental

        $dao = new \Inventory\Compound\DAO\SQL\Compound();

        $result = $dao->retrieve(
          [
            'fields' => ['id', 'name', 'cas'],
            'order_by' => ['id', 'name'],
            'where' => [['id', '>', 600]],
          ]
        );
        $dao->name = 'feco';
        $dao->subCategory = 9;

        // $result=$dao->create();
        return $dao->fetchResults($result);
        // return $dao->getInsertID($result);
    }
}
