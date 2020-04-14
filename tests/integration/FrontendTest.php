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

namespace Inventory\Test\Integration;

use Inventory\Core\Containers\Service;
use Inventory\Core\Containers\Template;
use Inventory\Core\Exception\AuthorizationException;
use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Core\Exception\RenderingError;
use Inventory\Core\Renderer;
use Inventory\Test\Framework\BaseTestCase;

/**
 * Frontend Integration Test Class
 *
 * @covers \Inventory\Core\Renderer
 * @covers \Inventory\Core\Exception\ExceptionHandler
 * @covers \Inventory\Core\Containers\Template
 * @covers \Inventory\Core\Containers\Service
 *
 * @group frontend
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class FrontendTest extends BaseTestCase
{
    /**
     * Exception handler
     *
     * @var \Inventory\Core\Exception\ExceptionHandler
     */
    protected ExceptionHandler $exHandler;

    /**
     * Template container
     *
     * @var \Inventory\Core\Containers\Template
     */
    protected Template $template;

    /**
     * Service container
     *
     * @var \Inventory\Core\Containers\Service
     */
    protected Service $service;

    /**
     * Renderer
     *
     * @var \Inventory\Core\Renderer
     */
    protected Renderer $renderer;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = new Service();
        $this->template = new Template();
        $this->exHandler = new ExceptionHandler();
    }

    /**
     * Test missing base template throws error
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\RenderingError
     */
    public function testMissingBaseTemplateFileError()
    {
        self::expectException(RenderingError::class);
        $this->renderer = $this->service->factory()->createRenderer($this->exHandler, $this->template);
        $this->renderer->run();
    }

    /**
     * Test login page render
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\RenderingError
     */
    public function testLoginPage()
    {
        // Set template
        $this->template->setBase('page');
        $this->template->setRegions('body', 'Page/Login');
        $this->template->setRegions('form', 'Form/Login');
        $this->renderer = $this->service->factory()->createRenderer($this->exHandler, $this->template);

        // Expect Doctype
        self::expectOutputRegex('/^<!DOCTYPE html>/');
        // Expect html tags
        self::expectOutputRegex('/<html.*>.*<head>.*<\/head>.*<body>.*<\/body>.*<\/html>/s');

        $this->renderer->run();
    }

    /**
     * Test error display
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\RenderingError
     */
    public function testErrorDisplay()
    {
        $ex = new AuthorizationException('test context');
        $this->renderer = $this->service->factory()->createRenderer($this->exHandler);

        // Expect Doctype
        self::expectOutputRegex('/^<!DOCTYPE html>/');
        // Expect html tags
        self::expectOutputRegex('/<html.*>.*<head>.*<\/head>.*<body>.*<\/body>.*<\/html>/s');
        // Expect context
        self::expectOutputRegex('/test context/i');

        $this->renderer->displayError($ex);
    }
}
