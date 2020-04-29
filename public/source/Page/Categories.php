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

use Inventory\Core\Utils;
use Inventory\Entity\Compound\BAO\Compound;

/**
 * Categories Page
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Categories extends \Inventory\Core\Controller\Page
{
    private ?int $id;

    /**
     * Validate input
     */
    protected function validate(): void
    {
        parent::validate();

        $id = $this->routeParams['id'] ?? 0;

        $this->id = Utils::sanitizeID($id);
    }

    /**
     * Process input
     */
    protected function process(): void
    {
        parent::process();

        $bao = $this->getBaO(Compound::class);

        if ($this->id >= 1) {
            $compounds = $bao->getCategoryCompound($this->id);
        } else {
            $compounds = $bao->getAll();
        }

        $this->setTemplateVar('compounds', $compounds);
    }

    /**
     * Assemble page
     */
    protected function assemble(): void
    {
        parent::assemble();

        $this->setBaseTemplate(Utils::getPathFromClass(self::class));
    }
}
