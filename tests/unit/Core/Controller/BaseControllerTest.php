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

namespace Inventory\Test\Unit\Core\Controller;

use Inventory\Core\Containers\Template;
use Inventory\Core\Controller\BaseController;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Renderer;
use Inventory\Core\Routing\Request;
use Inventory\Test\Framework\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Smarty;

/**
 * BaseControllerTest Class
 *
 * @covers \Inventory\Core\Controller\BaseController
 * @group minimal
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class BaseControllerTest extends BaseTestCase
{
    /**
     * Test object
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $testObject;

    /**
     * Mock renderer
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $renderer;

    /**
     * Set up method
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create stubs
        $request = $this->createStub(Request::class);
        $template = $this->createStub(Template::class);
        $engine = $this->createStub(Smarty::class);

        // Mock renderer
        $this->renderer = $this
          ->getMockBuilder(Renderer::class)
          ->setConstructorArgs([$engine, $template])
          ->getMock();

        // Mock test class
        $this->testClass = BaseController::class;
        $this->testObject = $this
          ->getMockBuilder(BaseController::class)
          ->setConstructorArgs([$request, $template, $this->renderer])
          ->getMockForAbstractClass();
    }

    /**
     * Test run calls renderer run
     */
    public function testRunStartsRenderer()
    {
        self::assertInstanceOf($this->testClass, $this->testObject);

        $this->renderer->expects(self::once())->method('run');
        $this->testObject->run();
    }

    /**
     * Test empty string throws exception
     *
     * @throws \ReflectionException
     */
    public function testEmptyStringThrowsExceptionAtBaseTemplate()
    {
        $this->expectException(BadArgument::class);
        $this->getProtectedMethod($this->testObject, 'setBaseTemplate', [self::STRING_EMPTY]);
    }

    /**
     * Test empty string throws exception
     *
     * @throws \ReflectionException
     */
    public function testEmptyStringThrowsExceptionAtTemplateRegion()
    {
        $this->expectException(BadArgument::class);
        $this->getProtectedMethod($this->testObject, 'setTemplateVar', [self::STRING_EMPTY, self::STRING]);
    }

    /**
     * Test empty string throws exception
     *
     * @throws \ReflectionException
     */
    public function testEmptyStringThrowsExceptionAtTemplateVariable()
    {
        $this->expectException(BadArgument::class);
        $this->getProtectedMethod($this->testObject, 'setTemplateRegion', [self::STRING_EMPTY, self::STRING]);
    }
}
