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

use Inventory\Core\Settings;
use Inventory\Test\Framework\BaseTestCase;

/**
 * SettingsTest Class
 *
 * @covers \Inventory\Core\Settings
 * @group minimal
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class SettingsTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\Settings
     */
    protected Settings $sut;

    /**
     * Set up
     */
    public function setUp():void
    {
        parent::setUp();
        $this->sut=new Settings();
    }

    /**
     * Test object is initialized
     */
    public function testObjectInitialized()
    {
        self::assertInstanceOf(Settings::class, $this->sut);
    }

    /**
     * Test settings are accessible
     */
    public function testSettingsAreAccessible()
    {
        // Non-existent domain
        self::assertNull($this->sut->getSetting('test', 'key'));
        self::assertNull($this->sut->getSetting('test', ''));

        // Write & read
        $this->sut->addSetting('test', '', '');
        self::assertNull($this->sut->getSetting('test', 'key'));

        $this->sut->addSetting('test', 'key', 41);
        self::assertNull($this->sut->getSetting('test', 'key_2'));

        self::assertSame(41, $this->sut->getSetting('test', 'key'));
    }

    /**
     * Test default config is loaded
     *
     * @throws \Inventory\Core\Exception\FileMissing
     * @throws \ReflectionException
     */
    public function testLoadDefaultsReturnsSetting()
    {
        $this->sut->loadDefaults();
        $defaults=$this->getProtectedProperty($this->sut, 'settings');
        self::assertIsArray($defaults);
        self::assertGreaterThanOrEqual(1, count($defaults));
    }
}
