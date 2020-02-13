<?php
/**
 * This file is part of chem-inventory.
 * Written by Sandor Semsey.
 *
 * Copyright (c) 2020.
 * This is work licenced under the GNU General Public License v3.0. All rights reserved.
 *
 * This is a free software;)
 */

namespace Inventory\Core;


/**
 * Interface for any database
 *
 * @package Inventory\Core
 */
interface IDataBase
{
  /**
   * Stores data in a database
   *
   * @param array $data
   *
   * @return mixed
   */
  public function store(array $data);

  /**
   * Retrieves data from database
   *
   * @param array $whatToRetrieve
   *
   * @return array requested data
   */
  public function retrieve(array $whatToRetrieve);
}
