<?php
/**
 +---------------------------------------------------------------------+
 | This file is part of chem-inventory.                                |
 |                                                                     |
 | Copyright (c) 2020 Sandor Semsey                                    |
 | All rights reserved.                                                |
 |                                                                     |
 | This work is published under the MIT License.                       |
 | https://choosealicense.com/licenses/mit/                            |
 |                                                                     |
 | It's a free software;)                                              |
 |                                                                     |
 | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 | SOFTWARE.                                                           |
 +---------------------------------------------------------------------+
 */

namespace Inventory\Test\Unit\Core\Exception;

use Inventory\Application;
use Inventory\Core\Exception\ExceptionHandler;
use Inventory\Core\Renderer;
use Inventory\Test\Framework\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * ExceptionHandlerTest Class
 *
 * @covers \Inventory\Core\Exception\ExceptionHandler
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
     * @var \Inventory\Core\Exception\ExceptionHandler
     */
    protected ExceptionHandler $exHandler;

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

        // Mock app
        $this->app=$this
          ->getMockBuilder(Application::class)
          ->onlyMethods(['exit'])
          ->getMock();

        // Mock renderer
        $this->renderer=$this
          ->getMockBuilder(Renderer::class)
          ->disableOriginalConstructor()
          ->onlyMethods(['displayError'])
          ->getMock();

        // Create SUT
        $this->exHandler=new ExceptionHandler($this->app, $this->renderer);
    }

    /**
     * Fatal error invokes exit
     */
    public function testFatalErrorCallsExit()
    {
        $this->app->expects(self::exactly(2))->method('exit');#->willReturn(true);
        $this->suppressOutput();

        $this->exHandler->handleFatalError();
        $this->exHandler->handleRendererError();
    }

    /**
     * Fatal error invokes display
     */
    public function testFatalErrorInvokesDynamicDisplayError()
    {
        $this->renderer->expects(self::once())->method('displayError');
        $this->exHandler->handleFatalError();
    }

    /**
     * Fatal renderer error invokes static error display
     */
    public function testFatalRendererErrorInvokesStaticErrorDisplay()
    {
        $this->expectOutputString('renderer error');
        $this->exHandler->handleRendererError();
    }

    /**
     * Exception handler decides which display mode
     */
    public function testExceptionHandlerDecideDynamicOrStaticDisplay()
    {
        // Expect static
        $this->exHandler=new ExceptionHandler($this->app);
        $this->expectOutputString('renderer error');
        $this->exHandler->handleFatalError();

    }

    /**
     * Fatal error writes to log
     */
    public function testFatalErrorWritesToLog()
    {
        self::markTestIncomplete();
    }
}
