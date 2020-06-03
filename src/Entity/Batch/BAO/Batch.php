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

namespace Inventory\Entity\Batch\BAO;

use Inventory\Core\BaseBaO;
use Inventory\Core\Containers\Service;
use Inventory\Entity\Manufacturer\DAO\Manufacturer;

/**
 * Batch Class
 *
 * @category Business Layer
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Batch extends BaseBaO
{
    /**
     * BaseBAO constructor.
     *
     * @param \Inventory\Core\Containers\Service $service
     */
    public function __construct(Service $service)
    {
        parent::__construct($service);
        $this->daoClass = \Inventory\Entity\Batch\DAO\Batch::class;
    }

    /**
     * Gets all batch of a given compound
     *
     * @param int $compound_id Compound ID
     *
     * @return array|null
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function getBatchOfCompound(int $compound_id): ?array
    {
        // Table names
        $batch_table = \Inventory\Entity\Batch\DAO\Batch::TABLE_NAME;
        $manfac_table = Manufacturer::TABLE_NAME;

        $params =
            [
                'fields' => [
                    "{$batch_table}.batch_id AS bid",
                    "{$manfac_table}.name AS manfac_name",
                    "{$batch_table}.name",
                    "{$batch_table}.lot",
                    "{$batch_table}.date_arr",
                    "{$batch_table}.date_open",
                    "{$batch_table}.date_exp",
                    "{$batch_table}.date_arch",
                    "{$batch_table}.note",
                ],
                'join' => [[$manfac_table, 'manfac_id']],
                'where' => [['compound_id', '=', $compound_id]],
                'order_by' => ["{$batch_table}.name"],
            ];

        return $this->retrieve($params);
    }
}
