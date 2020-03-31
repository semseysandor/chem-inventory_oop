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

namespace Inventory\Test\Integration;

use Inventory\Core\Containers\Service;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Factory;
use Inventory\Core\Settings;
use Inventory\Test\Framework\BaseTestCase;

/**
 * ServiceTest Class
 *
 * @covers \Inventory\Core\Containers\Service
 * @group integration
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class ServiceTest extends BaseTestCase
{
    public function testDatabaseObjectIsReturned()
    {
        self::markTestSkipped();
        self::assertInstanceOf(SQLDataBase::class, Service::database());
    }

    public function testFactoryObjectIsReturned()
    {
        self::assertInstanceOf(Factory::class, Service::factory());
        self::assertInstanceOf(Factory::class, Service::factory());
    }

    public function testSettingsObjectIsReturned()
    {
        self::assertInstanceOf(Settings::class, Service::settings());
    }
}
