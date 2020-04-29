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

namespace Inventory\Test\Unit\Core\Controller;

use Inventory\Core\Containers\Service;
use Inventory\Core\Containers\Template;
use Inventory\Core\Controller\BaseController;
use Inventory\Core\Controller\Form;
use Inventory\Core\Controller\Page;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Factory;
use Inventory\Page\Index;
use Inventory\Page\Login;
use Inventory\Page\Logout;
use Inventory\Test\Framework\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * BaseControllerTest Class
 *
 * @covers \Inventory\Core\Controller\BaseController
 * @covers \Inventory\Core\Controller\Page
 * @covers \Inventory\Core\Controller\Form
 * @covers \Inventory\Page\Login
 * @covers \Inventory\Page\Logout
 * @covers \Inventory\Page\Index
 * @covers \Inventory\Form\Login
 *
 * @uses   \Inventory\Core\Containers\Template
 *
 * @group controlling
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class ControllerTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\Controller\BaseController
     */
    protected BaseController $sut;

    /**
     * Test Template
     *
     * @var \Inventory\Core\Containers\Template
     */
    protected Template $template;

    /**
     * Request data
     *
     * @var array
     */
    protected array $requestData;

    /**
     * Route parameters
     *
     * @var array
     */
    protected array $routeParams;

    /**
     * Mock factory
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $factory;

    /**
     * Mock Service container
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $service;

    /**
     * Set up method
     */
    public function setUp(): void
    {
        parent::setUp();

        // Mock service
        $this->service = $this->getMockBuilder(Service::class)->getMock();

        // Mock request
        $this->requestData = self::ARRAY;

        // Mock route parameters
        $this->routeParams = self::ARRAY;

        // Mock template
        $this->template = new Template();

        // Mock factory
        $this->factory = $this->getMockBuilder(Factory::class)->getMock();

        $this->sut = new BaseController([], $this->requestData, $this->template, $this->service);
    }

    /**
     * Test controller is initialized
     *
     * @dataProvider provideClass
     *
     * @param string $class
     */
    public function testObjectIsInitialized(string $class)
    {
        // Mock test class
        $this->sut = new $class($this->routeParams, $this->requestData, $this->template, $this->service);

        self::assertInstanceOf($class, $this->sut);
    }

    /**
     * Provides class & base template name
     *
     * @return array
     */
    public function provideClass(): array
    {
        return [
          'base' => [BaseController::class],
          'Core Form' => [Form::class],
          'Core Page' => [Page::class],
          'Login Page' => [Login::class],
          'Index Page' => [Index::class],
          'Logout Page' => [Logout::class],
          'Login Form' => [\Inventory\Form\Login::class],
        ];
    }

    /**
     * Test run calls renderer run
     */
    public function testRunBuildsPageAndReturnTemplateContainer()
    {
        self::assertInstanceOf(Template::class, $this->sut->run());
    }

    /**
     * Test empty string throws exception
     *
     * @throws \ReflectionException
     */
    public function testEmptyStringThrowsExceptionAtBaseTemplate()
    {
        $this->expectException(BadArgument::class);
        $this->invokeProtectedMethod($this->sut, 'setBaseTemplate', [self::STRING_EMPTY]);
    }

    /**
     * Test empty string throws exception
     *
     * @throws \ReflectionException
     */
    public function testEmptyStringThrowsExceptionAtTemplateRegion()
    {
        $this->expectException(BadArgument::class);
        $this->invokeProtectedMethod($this->sut, 'setTemplateVar', [self::STRING_EMPTY, self::STRING]);
    }

    /**
     * Test empty string throws exception
     *
     * @throws \ReflectionException
     */
    public function testEmptyStringThrowsExceptionAtTemplateVariable()
    {
        $this->expectException(BadArgument::class);
        $this->invokeProtectedMethod($this->sut, 'setTemplateRegion', [self::STRING_EMPTY, self::STRING]);
    }

    /**
     * Properties are accessible
     *
     * @throws \ReflectionException
     */
    public function testPropertiesAreAccessible()
    {
        // Write
        $this->invokeProtectedMethod($this->sut, 'setBaseTemplate', [self::STRING]);
        $this->invokeProtectedMethod($this->sut, 'setTemplateVar', [self::STRING, self::ARRAY]);
        $this->invokeProtectedMethod($this->sut, 'setTemplateRegion', [self::STRING_SPEC, self::STRING]);

        // Read
        self::assertSame(self::STRING, $this->sut->getTemplateContainer()->getBase());
        self::assertSame([self::STRING => self::ARRAY], $this->sut->getTemplateContainer()->getVars());
        self::assertSame([self::STRING_SPEC => self::STRING], $this->sut->getTemplateContainer()->getRegions());
    }
}
