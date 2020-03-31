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

namespace Inventory\Testing\Core\Controller;

use Inventory\Core\Controller\BaseController;
use Inventory\Testing\Framework\BaseTestCase;

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
     * Set up method
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->testClass = BaseController::class;
        $this->testObject = $this->getMockForAbstractClass(BaseController::class);
    }

    /**
     *
     */
    public function testBaseControllerIsInitialized()
    {
        parent::assertObjectCreated();
        // parent::assertPropertyInitialized('templateContainer');
    }

    /**
     *
     */
    public function testControllerHasAttributes()
    {
        self::assertTrue(true);
        self::assertSame('jocobeco', BaseController::makilali());
    }
}
