<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020 Sandor Semsey                  |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

namespace Inventory\Page;

use Inventory\Core\Controller\Page;
use Inventory\Core\Routing\Security;

/**
 * Logout Class
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Logout extends Page
{

    /**
     * @inheritDoc
     */
    protected function validate(): void
    {
        // TODO: Implement validate() method.
    }

    /**
     * @inheritDoc
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function process(): void
    {
        $this->factory->create(Security::class)->logOut();
        header('Location: /');
        // TODO: Implement process() method.
    }

    /**
     * @inheritDoc
     */
    protected function assemble(): void
    {
        // TODO: Implement assemble() method.
    }
}
