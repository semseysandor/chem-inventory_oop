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

use Inventory\Core\Controller\Page;
use Inventory\Core\Utils;
use Inventory\Entity\Compound\BAO\Compound;

/**
 * SubCategories Page
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class SubCategories extends Page
{
    /**
     * SubCategory id
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

        $bao = $this->getBaO(Compound::class);

        // If id supplied --> list compounds in category
        if ($this->id >= 1) {
            $compounds = $bao->getSubCategoryCompound($this->id);
        } else {
            // No id --> list all
            $compounds = $bao->getAll();
        }

        $this->setTemplateVar('compounds', $compounds);
    }

    /**
     * Assemble page
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function assemble(): void
    {
        parent::assemble();

        $this->setBaseTemplate('Page/Compound');
    }
}
