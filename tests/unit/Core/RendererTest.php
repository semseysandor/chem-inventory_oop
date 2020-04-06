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

namespace Inventory\Test\Unit\Core;

use Inventory\Core\Containers\Template;
use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Core\Renderer;
use Inventory\Test\Framework\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Smarty;

/**
 * RendererTest Class
 *
 * @covers \Inventory\Core\Renderer
 *
 * @group rendering
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class RendererTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\Renderer
     */
    protected Renderer $sut;

    /**
     * Mock template
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $template;

    /**
     * Mock template engine
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $engine;

    protected MockObject $exHandler;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->template = $this->getMockBuilder(Template::class)->getMock();
        $this->engine = $this->getMockBuilder(Smarty::class)->getMock();
        $this->exHandler = $this->getMockBuilder(ExceptionHandler::class)->getMock();
        $this->sut = new Renderer($this->exHandler, $this->engine, $this->template);
    }

    /**
     * Test renderer is initialized
     */
    public function testObjectIsInitialized()
    {
        self::assertInstanceOf(Renderer::class, $this->sut);
    }

    /**
     * Test run start smarty display
     *
     * @throws \SmartyException
     */
    public function testRunStartSmartyRenderProcess()
    {
        $this->engine->expects(self::once())->method('display');
        $this->sut->run();
    }
}
