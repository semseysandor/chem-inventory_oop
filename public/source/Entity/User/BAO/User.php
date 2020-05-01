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

namespace Inventory\Entity\User\BAO;

use Inventory\Core\BaseBaO;

/**
 * User BAO Class
 *
 * @category BAO
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class User extends BaseBaO
{
    /**
     * Search user in DataBase
     *
     * @param string $user User name
     *
     * @return array|null
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function searchUser(string $user)
    {
        // Create dao
        $dao = $this->getDaO(\Inventory\Entity\User\DAO\User::class);

        // Retrieve user info
        $result = $dao->retrieve(
            [
                'fields' => ['user_id', 'hash', 'name'],
                'where' => [
                    ['name', 'like', "'{$user}'"],
                ],
                'limit' => 1,
            ]
        );

        // Fetch results
        $result = $dao->fetchResultsOne($result);

        if (is_null($result)) {
            return null;
        }

        // Format & return results
        $data['id'] = $result['user_id'];
        $data['hash'] = $result['hash'];
        $data['name'] = $result['name'];

        return $data;
    }
}
