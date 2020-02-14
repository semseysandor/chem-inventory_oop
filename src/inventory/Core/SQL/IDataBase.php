<?php
/**
 * This file is part of chem-inventory.
 * Written by Sandor Semsey.
 *
 * Copyright (c)  2020.
 * This is work licenced under the GNU General Public License v3.0. All rights reserved.
 *
 * This is a free software;)
 */

namespace Inventory\Core\SQL;

/**
 * Interface IDataBase
 *
 * @package Inventory\Core\SQL
 */
interface IDataBase
{
    /**
     * Retrieves entity from database
     *
     * @param $data
     *
     * @return mixed
     */
    public function retrieve($data);

    /**
     * @param $data
     *
     * @return mixed
     */
    public function create($data);

    /**
     * @param $data
     *
     * @return mixed
     */
    public function update($data);

    /**
     * @param $data
     *
     * @return mixed
     */
    public function delete($data);
}
