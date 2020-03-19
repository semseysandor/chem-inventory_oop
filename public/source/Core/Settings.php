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

namespace Inventory\Core;

use Inventory\Core\Exception\FileMissing;

/**
 * Settings Manager
 *
 * @category Config
 * @package  Inventory
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Settings
{
    /**
     * Array to hold configs
     *
     * @var array
     */
    private array $settings;

    /**
     * Singleton instance
     *
     * @var \Inventory\Core\Settings|null
     */
    private static ?Settings $instance = null;

    /**
     * Settings constructor.
     *
     * @throws FileMissing
     */
    private function __construct()
    {
        $this->settings = self::getDefaults();
    }

    /**
     * Loads defaults settings from file
     *
     * @return array
     *
     * @throws FileMissing
     */
    private static function getDefaults(): array
    {
        $config_file = ROOT.'/config.php';
        if (!file_exists($config_file)) {
            throw new FileMissing(ts('Settings file could not be loaded'));
        }

        return include $config_file;
    }

    /**
     * Singleton
     *
     * @return $this
     *
     * @throws FileMissing
     */
    public static function singleton()
    {
        if (self::$instance == null) {
            self::$instance = new Settings();
        }

        return self::$instance;
    }

    /**
     * Gets a particular setting
     *
     * @param string $domain
     * @param string $key Name of setting to fetch
     *
     * @return mixed|null
     */
    public function getSetting(string $domain, string $key)
    {
        // Check for domain
        if (!array_key_exists($domain, $this->settings)) {
            return null;
        }

        // Check for key
        if (!array_key_exists($key, ($this->settings)[$domain])) {
            return null;
        }

        return ($this->settings)[$domain][$key];
    }

    /**
     * Adds a config
     *
     * @param array $cfgToAdd Config to add
     *                        format: ['name' => 'value']
     *
     * @return void
     */
    public function addSetting(array $cfgToAdd): void
    {
        foreach ($cfgToAdd as $key => $value) {
            $this->settings[$key] = $value;
        }
    }
}
