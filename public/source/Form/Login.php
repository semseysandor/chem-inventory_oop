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

use Inventory\Core\Controller\BaseController;

/**
 * Login Form
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Login extends BaseController
{
    /**
     * Process input
     *
     * @return void
     */
    protected function process(): void
    {
        parent::process();

        // TODO: implement
        $data = $this->requestData;
        if (empty($data)) {
            return;
        }

        $_SESSION['USER_NAME'] = $data['user'];
        header('Location: /');
        exit;
    }
}
