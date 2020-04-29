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

        // Parse JSON
        $request_json = json_decode($this->requestData['data']);

        // Get request data
        $user = $request_json->user ?? "";
        $pass = $request_json->pass ?? "";
        $token = $request_json->token ?? "";

        // Sanitize
        $this->user = Utils::sanitizeString($user, 'word');
        $this->pass = trim($pass);

        // Check token
        if (!$this->validateToken($token)) {
            $this->errorFlag = true;
            $this->response = ts('Token mismatch.');

            return;
        }

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
     */
    protected function process(): void
    {
        parent::process();

        // Error in validation
        if ($this->errorFlag) {
            return;
        }

        // Search user in DB
        $bao = $this->getBaO(User::class);
        $result = $bao->searchUser($this->user);

        // Get number of failed login attempt in this session
        $_SESSION['LOGIN_FAILED_ATTEMPT'] = $_SESSION['LOGIN_FAILED_ATTEMPT'] ?? 0;

        // Increase waiting time with login attempts to slow down brute force attacks
        sleep(2 ** $_SESSION['LOGIN_FAILED_ATTEMPT']);

        // User not exist
        if (is_null($result)) {
            $_SESSION['LOGIN_FAILED_ATTEMPT'] += 1;
            $this->errorFlag = true;
            $this->response = ts('Invalid user name or password.');

            return;
        }

        // Authenticate user & password
        $security = $this->service->security();
        $authorized = $security->authenticate($this->pass, $result['hash']);

        // Log in
        if ($authorized) {
            unset($_SESSION['LOGIN_FAILED_ATTEMPT']);
            $security->logIn($result['id'], $result['name']);
            $this->response = ts('Logged in successfully.');
        } else {
            $_SESSION['LOGIN_FAILED_ATTEMPT'] += 1;
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
        $this->templateContainer->setBase('ajax');
        $this->templateContainer->setVars('flag', ($this->errorFlag ? 'neg' : 'pos'));
        $this->templateContainer->setVars('text', $this->response);
    }
}
