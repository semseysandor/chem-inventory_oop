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
use Inventory\Entity\Category\BAO\Category;

/**
 * Index Page
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Index extends Page
{
    /**
     * Process input
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function process(): void
    {
        parent::process();

        // Get categories
        $category = $this->getBaO(Category::class);
        $this->setTemplateVar('categories', $category->getCategories());
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
        $this->setTemplateVar('user_id', $_SESSION['USER_ID']);
        $this->setTemplateVar('user_name', $_SESSION['USER_NAME']);
    }
}
