<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | (c) Sandor Semsey <semseysandor@gmail.com>    |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 |                                               |
 | It's a free software;)                        |
 +-----------------------------------------------+
 */

/**
 * +-----------------------------------------------+
 * | This file is part of chem-inventory.          |
 * |                                               |
 * | (c) Sandor Semsey <semseysandor@gmail.com>    |
 * | All rights reserved.                          |
 * |                                               |
 * | This work is published under the MIT License. |
 * | https://choosealicense.com/licenses/mit/      |
 * |                                               |
 * | It's a free software;)                        |
 * +-----------------------------------------------+
 */

namespace Inventory\Page;

use Inventory\Core\Controller\Page;
use Inventory\Core\Utils;

/**
 * Login Class
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Login extends Page
{
    /**
     * Validate input
     *
     * @return void
     */
    protected function validate(): void
    {
    }

    /**
     * Process input
     *
     * @return void
     */
    protected function process(): void
    {
    }

    /**
     * Assemble page
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function assemble(): void
    {
        $this->setTemplateRegion('body', Utils::getPathFromClass(self::class));
        $this->setTemplateRegion('form', Utils::getPathFromClass(\Inventory\Form\Login::class));
    }
}
