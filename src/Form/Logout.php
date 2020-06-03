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

namespace Inventory\Form;

use Inventory\Core\Controller\Form;

/**
 * Logout Class
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Logout extends Form
{
    /**
     * Process input
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Exception
     */
    protected function process(): void
    {
        parent::process();

        $this->service->security()->logOut();
    }

    /**
     * Assemble page
     */
    protected function assemble(): void
    {
        parent::assemble();

        header('Content-Type: application/json');

        $this->templateContainer->setBase('ajax');
        $this->templateContainer->setVars('flag', ($this->errorFlag ? 'neg' : 'pos'));
        $this->templateContainer->setVars('text', $this->response);
    }
}
