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

namespace Inventory\Core;

use Inventory\Core\Containers\Service;
use Inventory\Core\DataBase\SQLDaO;

/**
 * Base Business Application Object
 *
 * @category BAO
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class BaseBaO
{
    /**
     * Service container
     *
     * @var \Inventory\Core\Containers\Service
     */
    protected Service $service;

    /**
     * BaseBAO constructor.
     *
     * @param \Inventory\Core\Containers\Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Creates a new DaO
     *
     * @param string $dao_class DAO class name
     *
     * @return \Inventory\Core\DataBase\SQLDaO
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    protected function getDaO(string $dao_class): SQLDaO
    {
        return $this
          ->service
          ->factory()
          ->createDaO($this->service->database(), $dao_class);
    }
}
