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
use Inventory\Core\Utils;
use Inventory\Entity\User\BAO\User;

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
     * User name
     *
     * @var string
     */
    protected string $user;

    /**
     * Password
     *
     * @var string
     */
    protected string $pass;

    /**
     * Validate input
     */
    protected function validate(): void
    {
        parent::validate();

        // Get request data
        $user = $this->requestData['user'] ?? "";
        $pass = $this->requestData['pass'] ?? "";

        // Sanitize
        $this->user = Utils::sanitizeString($user, 'word');
        $this->pass = trim($pass);

        // Check missing
        if ($this->user == '') {
            $this->errorFlag = true;
            $this->response = ts('Missing user name.');

            return;
        }
        if ($this->pass == '') {
            $this->errorFlag = true;
            $this->response = ts('Missing password.');

            return;
        }
    }

    /**
     * Process input
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    protected function process(): void
    {
        parent::process();

        // Error in validation
        if ($this->errorFlag) {
            return;
        }

        // Search user in DB
        $bao = new User($this->service);
        $result = $bao->searchUser($this->user);

        // User not exist
        if (is_null($result)) {
            $this->errorFlag = true;
            $this->response = ts('Invalid user name or password.');

            return;
        }

        // Authenticate user & password
        $security = $this->service->security();
        $authorized = $security->authenticate($this->pass, $result['hash']);

        // Log in
        if ($authorized) {
            $security->logIn($result['id']);
            $this->response = ts('Logged in successfully.');
        } else {
            $this->errorFlag = true;
            $this->response = ts('Invalid user name or password.');
        }
    }

    /**
     * Assemble page
     */
    protected function assemble(): void
    {
        parent::assemble();
        $this->templateContainer->setBase('base/response');
        $this->templateContainer->setVars('flag', ($this->errorFlag ? 'neg' : 'pos'));
        $this->templateContainer->setVars('text', $this->response);
    }
}
