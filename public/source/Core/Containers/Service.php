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

namespace Inventory\Core\Containers;

use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Factory;
use Inventory\Core\Settings;

/**
 * Service container for accessing major subsystems
 *
 * @category Container
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Service
{
    /**
     * Factory
     *
     * @var \Inventory\Core\Factory|null
     */
    private static ?Factory $factory = null;

    /**
     * Gets the settings subsystem
     *
     * @return \Inventory\Core\Settings
     *
     * @throws \Inventory\Core\Exception\FileMissing
     */
    public static function settings()
    {
        return Settings::singleton();
    }

    /**
     * Gets the DataBase handler
     *
     * @return \Inventory\Core\DataBase\SQLDataBase
     *
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \Inventory\Core\Exception\FileMissing
     */
    public static function database()
    {
        return SQLDataBase::singleton(self::settings());
    }

    /**
     * Gets the factory
     *
     * @return \Inventory\Core\Factory|null
     */
    public static function factory()
    {
        if (self::$factory == null) {
            self::$factory = new Factory();
        }

        return self::$factory;
    }
}
