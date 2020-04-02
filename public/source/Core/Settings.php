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
 * @category Settings
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Settings
{
    /**
     * Config file
     */
    private const DEFAULT_CONFIG_FILE = ROOT.'/config.php';

    /**
     * Array to hold settings
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
     */
    public function __construct()
    {
        $this->settings = [];
    }

    /**
     * Loads defaults settings from file
     *
     * @param string|null $config_file
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\FileMissing
     */
    public function loadDefaults(string $config_file = null): void
    {
        // Fallback to default config file
        if (empty($config_file)|| !file_exists($config_file)) {
            $config_file=self::DEFAULT_CONFIG_FILE;
        }

        if (!file_exists($config_file)) {
            throw new FileMissing(ts('Settings file could not be loaded.'));
        }

        $this->settings = require self::DEFAULT_CONFIG_FILE;
    }

    /**
     * Gets a particular setting
     *
     * @param string $domain Domain of setting
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

        // Return setting
        return ($this->settings)[$domain][$key];
    }

    /**
     * Adds a config
     *
     * @param string $domain Config domain
     * @param string $key Name of setting
     * @param mixed $value Value for setting
     *
     * @return void
     */
    public function addSetting(string $domain, string $key, $value): void
    {
        // Check for argument
        if (empty($domain) || empty($key)) {
            return;
        }

        $this->settings[$domain][$key] = $value;
    }
}
