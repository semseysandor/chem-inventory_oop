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
use Inventory\Core\Factory;
use Inventory\Test\Framework\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * BaseControllerTest Class
 *
 * @covers \Inventory\Core\Controller\BaseController
 * @covers \Inventory\Core\Controller\Form
 * @covers \Inventory\Core\Controller\Page
 * @uses   \Inventory\Core\Containers\Template
 *
 * @group Controller
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
     * Request data
     *
     * @var array
     */
    protected array $requestData;

    /**
     * Mock factory
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $factory;

    /**
     * Set up method
     */
    public function setUp(): void
    {
        parent::setUp();

        // Mock request
        $this->requestData = self::ARRAY;

        // Mock template
        $this->template = new Template();

        // Mock factory
        $this->factory = $this->getMockBuilder(Factory::class)->getMock();
    }

    /**
     * Mocks test object
     *
     * @param string $class
     */
    protected function mockController(string $class)
    {
        $this->sut = $this
          ->getMockBuilder($class)
          ->setConstructorArgs([$this->requestData, $this->template, $this->factory])
          ->getMockForAbstractClass();
    }

    /**
     * Provides class & base template name
     *
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

    /**
     * Test controller is initialized
     *
     * @dataProvider provideClass
     *
     * @param string $class
     * @param mixed $base_template
     *
     */
    public function testObjectIsInitialized(string $class, $base_template)
    {
        // Mock test class
        $this->mockController($class);

        self::assertInstanceOf($class, $this->sut);

        self::assertSame($base_template, $this->sut->getTemplateContainer()->getBase());
    }

    /**
     * Test run calls renderer run
     */
    public function testRunBuildsPageAndReturnTemplateContainer()
    {
        // Mock test class
        $this->mockController(BaseController::class);

        $this->sut->expects(self::once())->method('validate');
        $this->sut->expects(self::once())->method('process');
        $this->sut->expects(self::once())->method('assemble');
        self::assertInstanceOf(Template::class, $this->sut->run());
    }

    /**
     * Test empty string throws exception
     *
     * @throws \ReflectionException
     */
    public function testEmptyStringThrowsExceptionAtBaseTemplate()
    {
        // Mock test class
        $this->mockController(BaseController::class);

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
        $this->mockController(BaseController::class);

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
        $this->mockController(BaseController::class);

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
        // Mock controller
        $this->mockController(BaseController::class);

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
