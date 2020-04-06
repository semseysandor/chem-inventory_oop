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

namespace Inventory\Test\Unit\Core\Exception;

use Inventory\Core\Exception\BaseException;
use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Core\Renderer;
use Inventory\Test\Framework\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * ExceptionHandlerTest Class
 *
 * @covers \Inventory\Core\Exception\ExceptionHandler
 *
 * @group Exception
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class ExceptionHandlerTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $sut;

    /**
     * Application mock
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $app;

    /**
     * Renderer mock
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $renderer;

    /**
     * Set up
     */
    public function setUp():void
    {
        parent::setUp();

        // Mock renderer
        $this->renderer = $this
          ->getMockBuilder(Renderer::class)
          ->disableOriginalConstructor()
          ->onlyMethods(['displayError'])
          ->getMock();

        // Mock SUT
        $this->sut = $this
          ->getMockBuilder(ExceptionHandler::class)
          ->setConstructorArgs([$this->renderer])
          ->onlyMethods(['exitWithFail'])
          ->getMock();
    }

    /**
     * Fatal error invokes exit
     */
    public function testFatalErrorCallsExit()
    {
        $this->sut->expects(self::exactly(2))->method('exitWithFail');
        $this->suppressOutput();

        $this->sut->handleFatalError(new BaseException());
        $this->sut->handleRenderingError(new BaseException());
    }

    /**
     * Fatal error invokes dynamic error display
     */
    public function testFatalErrorInvokesDynamicErrorDisplay()
    {
        $this->renderer->expects(self::once())->method('displayError');
        $this->sut->handleFatalError(new BaseException());
    }

    /**
     * Fatal renderer error invokes static error display
     */
    public function testFatalRendererErrorInvokesStaticErrorDisplay()
    {
        $this->expectOutputRegex('/ERROR/');
        $this->sut->handleRenderingError(new BaseException());
    }

    /**
     * Exception handler decides which display mode
     * No renderer present --> static display
     */
    public function testExceptionHandlerDecideDynamicOrStaticDisplay()
    {
        // Mock SUT
        $this->sut = $this
          ->getMockBuilder(ExceptionHandler::class)
          ->onlyMethods(['exitWithFail'])
          ->getMock();
        $this->expectOutputRegex('/ERROR/');
        $this->sut->handleFatalError(new BaseException());
    }

    /**
     * Fatal error writes to log
     */
    public function testFatalErrorWritesToLog()
    {
        self::markTestIncomplete();
    }
}
