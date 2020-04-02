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
use Inventory\Core\Controller\Form;
use Inventory\Core\Controller\Page;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Renderer;
use Inventory\Core\Routing\Request;
use Inventory\Test\Framework\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Smarty;

/**
 * BaseControllerTest Class
 *
 * @covers \Inventory\Core\Controller\BaseController
 * @covers \Inventory\Core\Controller\Form
 * @covers \Inventory\Core\Controller\Page
 * @uses   \Inventory\Core\Containers\Template
 * @group minimal
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
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $sut;

    /**
     * Test Template
     *
     * @var \Inventory\Core\Containers\Template
     */
    protected Template $template;

    /**
     * Mock request
     *
     * @var \PHPUnit\Framework\MockObject\Stub
     */
    protected Stub $request;

    /**
     * Mock engine
     *
     * @var \PHPUnit\Framework\MockObject\Stub
     */
    protected Stub $engine;

    /**
     * Mock renderer
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $renderer;

    /**
     * Test Class
     *
     * @var string
     */
    protected string $testClass;

    /**
     * Set up method
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create stubs
        $this->request = $this->createStub(Request::class);
        $this->template = new Template();
        $this->engine = $this->createStub(Smarty::class);

        // Mock renderer
        $this->renderer = $this
          ->getMockBuilder(Renderer::class)
          ->setConstructorArgs([$this->engine, $this->template])
          ->getMock();
    }

    /**
     * Mocks test object
     *
     * @param string $class
     */
    protected function mockTestObject(string $class)
    {
        $this->testClass = $class;
        $this->sut = $this
          ->getMockBuilder($class)
          ->setConstructorArgs([$this->request, $this->template, $this->renderer])
          ->getMockForAbstractClass();
    }

    /**
     * Test run calls renderer run
     */
    public function testRunStartsRenderer()
    {
        // Mock test class
        $this->mockTestObject(BaseController::class);

        self::assertInstanceOf(BaseController::class, $this->sut);

        $this->renderer->expects(self::once())->method('run');
        $this->sut->run();
    }

    /**
     * Test empty string throws exception
     *
     * @throws \ReflectionException
     */
    public function testEmptyStringThrowsExceptionAtBaseTemplate()
    {
        // Mock test class
        $this->mockTestObject(BaseController::class);

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
        // Mock test class
        $this->mockTestObject(BaseController::class);

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
        // Mock test class
        $this->mockTestObject(BaseController::class);

        $this->expectException(BadArgument::class);
        $this->invokeProtectedMethod($this->sut, 'setTemplateRegion', [self::STRING_EMPTY, self::STRING]);
    }

    /**
     * Test controller is initialized
     *
     * @dataProvider provideClass
     *
     * @param string $class
     * @param mixed $base_template
     *
     * @throws \ReflectionException
     */
    public function testControllerIsInitialized(string $class, $base_template)
    {
        // Mock test class
        $this->mockTestObject($class);

        self::assertInstanceOf($this->testClass, $this->sut);
        $template = $this->getProtectedProperty($this->sut, 'templateContainer');

        self::assertSame($base_template, $template->getBase());
    }

    /**
     * @return array
     */
    public function provideClass(): array
    {
        return [
          'base' => [BaseController::class, null],
          'form' => [Form::class, 'form'],
          'page' => [Page::class, 'page'],

        ];
    }
}
