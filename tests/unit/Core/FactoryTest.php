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

namespace Inventory\Test\Unit\Core;

use Inventory\Core\Containers\Template;
use Inventory\Core\Controller\BaseController;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Factory;
use Inventory\Core\Renderer;
use Inventory\Core\Routing\Request;
use Inventory\Core\Routing\Router;
use Inventory\Page\Login;
use Inventory\Test\Framework\BaseTestCase;

/**
 * FactoryTest Class
 *
 * @covers \Inventory\Core\Factory
 * @group minimal
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class FactoryTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\Factory
     */
    protected Factory $sut;

    /**
     * Set up
     */
    public function setUp():void
    {
        parent::setUp();
        $this->sut=new Factory();
    }

    /**
     * Test creating router
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateRouterReturnsRouter()
    {
        self::assertInstanceOf(Router::class, $this->sut->createRouter());
    }

    /**
     * Test creating controller
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateControllerReturnsController()
    {
        $request=$this->createStub(Request::class);
        $controller=$this->sut->createController(Login::class, $request);

        self::assertInstanceOf(Login::class, $controller);
    }

    /**
     * Test non-existent controller throws error
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testCreateNonExistentControllerThrowsException()
    {
        self::expectException(BadArgument::class);
        $request=$this->createStub(Request::class);
        $this->sut->createController(BaseController::class, $request);
    }

    /**
     * Test non-existent class throws exception
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testNonExistentClassThrowsException()
    {
        self::expectException(BadArgument::class);
        $this->sut->create('NonExistentClass');
    }

    /**
     * Test creating renderer
     */
    public function testCreateRendererReturnsRenderer()
    {
        $template=$this->createStub(Template::class);

        // With Template
        $renderer=$this->sut->createRenderer($template);
        self::assertInstanceOf(Renderer::class, $renderer);

        // Without template
        $renderer=$this->sut->createRenderer($template);
        self::assertInstanceOf(Renderer::class, $renderer);
    }
}
