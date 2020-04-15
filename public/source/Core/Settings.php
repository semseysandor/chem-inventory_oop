<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020                                |
 | Sandor Semsey <semseysandor@gmail.com>        |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

namespace Inventory\Core;

use Inventory\Core\Exception\FileMissing;

/**
 * Settings Manager
 *
 * @category Framework
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
    public const DEFAULT_CONFIG_FILE = ROOT.'/config.php';

    /**
     * Array to hold settings
     *
     * @var array
     */
    private array $settings;

    /**
     * Default config file
     *
     * @var string
     */
    private string $configFile;

    /**
     * Settings constructor.
     *
     * @param string $default_config_file Default config file
     */
    public function __construct(string $default_config_file = null)
    {
        $this->settings = [];
        // No files given --> fallback to wired default
        $this->configFile = $default_config_file ?? self::DEFAULT_CONFIG_FILE;
    }

    /**
     * Loads config file, if none given, fallback to default config file
     *
     * @param string $config_file
     *
     * @throws \Inventory\Core\Exception\FileMissing
     */
    public function loadConfigFile(string $config_file = ''): void
    {
        // Fallback to default config file
        if (empty($config_file)) {
            $config_file = $this->configFile;
        }

        // Check file is ready
        if (!file_exists($config_file) || !is_readable($config_file)) {
            throw new FileMissing(ts('Settings file "%s" could not be loaded.', $config_file));
        }

        // Load configs
        $configs = require $config_file;

        // Add to settings
        foreach ($configs as $domain => $settings) {
            foreach ($settings as $key => $value) {
                $this->addSetting($domain, $key, $value);
            }
        }
    }

    /**
     * Gets a particular setting
     *
     * @param string $domain Domain of setting
     * @param string $key Name of setting to fetch
     *
     * @return mixed|null Value of setting
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
