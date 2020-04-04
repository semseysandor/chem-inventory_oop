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

namespace Inventory\Form;

use Inventory\Core\Controller\Form;

/**
 * Login Form
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Login extends Form
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
        // TODO: implement
        $data = $this->requestData;
        if (empty($data)) {
            return;
        }

        $_SESSION['USER_NAME'] = $data['user'];
        header('Location: /');
        exit;
    }

    /**
     * Assemble page
     *
     * @return void
     */
    protected function assemble(): void
    {
    }
}
