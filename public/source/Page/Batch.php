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

namespace Inventory\Page;

use Inventory\Core\Controller\BaseController;
use Inventory\Core\Utils;

/**
 * Batch Class
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Batch extends BaseController
{
    /**
     * Compound id
     *
     * @var int|null
     */
    private ?int $id;

    /**
     * Validate input
     */
    protected function validate(): void
    {
        parent::validate();

        // Get id from route
        $id = $this->routeParams['id'] ?? 0;

        // Sanitize ID
        $this->id = Utils::sanitizeID($id);
    }

    /**
     * Process input
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function process(): void
    {
        parent::process();

        $bao = $this->getBaO(\Inventory\Entity\Batch\BAO\Batch::class);

        $batches = $bao->getBatchOfCompound($this->id);

        $this->setTemplateVar('batches', $batches);
    }

    /**
     * Assemble page
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function assemble(): void
    {
        parent::assemble();

        $this->setBaseTemplate(Utils::getPathFromClass(self::class));
    }
}
