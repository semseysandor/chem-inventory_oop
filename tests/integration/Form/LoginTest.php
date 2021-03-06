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

namespace Inventory\Test\Integration\Form;

use Inventory\Core\Containers\Template;
use Inventory\Form\Login;
use Inventory\Test\Framework\IntegrationTestCase;

/**
 * Login Form Integration Test Class
 *
 * @covers \Inventory\Form\Login
 * @covers \Inventory\Entity\User\BAO\User
 * @covers \Inventory\Entity\User\DAO\User
 * @covers \Inventory\Core\Routing\Security
 * @covers \Inventory\Core\Routing\SessionManager
 *
 * @category
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class LoginTest extends IntegrationTestCase
{
    /**
     * Login form
     *
     * @var \Inventory\Form\Login
     */
    protected Login $form;

    /**
     * LoginTest constructor.
     *
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct()
    {
        parent::__construct();

        $this->setUpServices();

        $this->service->database()->execute('TRUNCATE TABLE main_users');
    }

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create form
        $this->form = new Login([], [], new Template(), $this->service);

        // Set session token
        $_SESSION['TOKEN'] = '12fe';
    }

    /**
     * Run form controller
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\RenderingError
     */
    public function runForm()
    {
        $template = $this->form->run();
        $renderer = $this->service->factory()->createRenderer($this->exHandler, $template);
        $renderer->run();
    }

    /**
     * Test Token mismatch
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\RenderingError
     * @throws \ReflectionException
     */
    public function testTokenMismatch()
    {
        // Mock request data
        $request = [
            'other' => 'test',
            'token' => 'invalid',
        ];

        $this->setProtectedProperty($this->form, 'requestData', $request);

        // Expect output
        $expected = '/.*neg.*'.ts('Token mismatch.').'/Us';
        self::expectOutputRegex($expected);

        // Control
        $this->runForm();
    }

    /**
     * Test missing user name
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\RenderingError
     * @throws \ReflectionException
     */
    public function testMissingUserNameError()
    {
        // Mock request data
        $request = [
            'other' => 'test',
            'token' => '12fe',
        ];

        $this->setProtectedProperty($this->form, 'requestData', $request);

        // Expect output
        $expected = '/.*neg.*'.ts('Missing user name.').'/Us';
        self::expectOutputRegex($expected);

        // Control
        $this->runForm();
    }

    /**
     * Test non-existent user
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\RenderingError
     * @throws \ReflectionException
     */
    public function testNonExistentUser()
    {
        // Mock request data
        $request = [
            'user' => 'NON-EXISTENT',
            'pass' => 'test',
            'token' => '12fe',
        ];

        $this->setProtectedProperty($this->form, 'requestData', $request);

        // Expect output
        $expected = '/.*neg.*'.ts('Invalid user name or password.').'/Us';
        self::expectOutputRegex($expected);

        // Control
        $this->runForm();
    }

    /**
     * Creates a user in DB
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function createUser()
    {
        // Create user
        $user = 'user';
        $pass = 'test';
        $options = [
          'memory_cost' => 512,
          'time_cost' => 1,
          'threads' => 1,
        ];

        // Generate hash & salt
        $hash = password_hash($pass, PASSWORD_ARGON2ID, $options);

        // Insert to DB
        $this->service->database()->import(
            [
            'query' => 'INSERT INTO main_users (name, hash) VALUES (?,?)',
            'bind' => 'ss',
            'values' => [$user, $hash],
            ]
        );
    }

    /**
     * Test invalid password
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\RenderingError
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \ReflectionException
     */
    public function testInvalidPassword()
    {
        $this->createUser();

        // Set form
        $request = [
            'user' => 'user',
            'pass' => 'INVALID',
            'token' => '12fe',
        ];

        $this->setProtectedProperty($this->form, 'requestData', $request);

        // Expect output
        $expected = '/.*neg.*'.ts('Invalid user name or password.').'/Us';
        self::expectOutputRegex($expected);

        // Control
        $this->runForm();
    }

    /**
     * Test valid password
     *
     * @depends testInvalidPassword
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\RenderingError
     * @throws \ReflectionException
     */
    public function testValidPassword()
    {
        // Set form
        $request = [
            'user' => 'user',
            'pass' => 'test',
            'token' => '12fe',
        ];

        $this->setProtectedProperty($this->form, 'requestData', $request);

        // Expect output
        $expected = '/.*pos.*'.ts('Logged in successfully.').'/Us';
        self::expectOutputRegex($expected);

        // Control
        $this->runForm();
    }
}
