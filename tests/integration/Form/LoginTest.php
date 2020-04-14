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

use Inventory\Core\Containers\Service;
use Inventory\Core\Containers\Template;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Form\Login;
use Inventory\Test\Framework\BaseTestCase;
use Inventory\Test\Framework\HeadlessDataBaseTrait;

/**
 * Login Form Integration Test Class
 *
 * @covers \Inventory\Form\Login
 * @covers \Inventory\Entity\User\BAO\User
 * @covers \Inventory\Entity\User\DAO\User
 *
 * @category
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class LoginTest extends BaseTestCase
{
    use HeadlessDataBaseTrait;

    /**
     * Login form
     *
     * @var \Inventory\Form\Login
     */
    protected Login $form;

    /**
     * Service container
     *
     * @var \Inventory\Core\Containers\Service
     */
    protected Service $service;

    /**
     * LoginTest constructor.
     *
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \ReflectionException
     */
    public function __construct()
    {
        parent::__construct();

        // Service container
        $this->service = new Service();

        // Test DataBase
        $db = new SQLDataBase($this->host, $this->port, $this->name, $this->user, $this->pass);
        $db->connect();
        $this->truncateTestDB();

        // Give test DB to services
        $this->setProtectedProperty($this->service, 'dataBase', $db);
    }

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create form
        $this->form = new Login([], new Template(), $this->service);
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
        $renderer = $this->service->factory()->createRenderer(new ExceptionHandler(), $template);
        $renderer->run();
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
        $request_data = ['other field' => 'test'];
        $this->setProtectedProperty($this->form, 'requestData', $request_data);

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
        $request_data = [
          'user' => 'NON-EXISTENT',
          'pass' => 'test',
        ];
        $this->setProtectedProperty($this->form, 'requestData', $request_data);

        // Expect output
        $expected = '/.*neg.*'.ts('Invalid user name or password.').'/Us';
        self::expectOutputRegex($expected);

        // Control
        $this->runForm();
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

        // Set form
        $request_data = [
          'user' => 'user',
          'pass' => 'INVALID',
        ];
        $this->setProtectedProperty($this->form, 'requestData', $request_data);

        // Expect output
        $expected = '/.*neg.*'.ts('Invalid user name or password.').'/Us';
        self::expectOutputRegex($expected);

        // Control
        $this->runForm();
    }

    /**
     * Test valid password
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\RenderingError
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \ReflectionException
     */
    public function testValidPassword()
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

        // Set form
        $request_data = [
          'user' => 'user',
          'pass' => 'test',
        ];
        $this->setProtectedProperty($this->form, 'requestData', $request_data);

        // Expect output
        $expected = '/.*pos.*'.ts('Logged in successfully.').'/Us';
        self::expectOutputRegex($expected);

        // Control
        $this->runForm();
    }
}
