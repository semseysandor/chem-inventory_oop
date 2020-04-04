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

namespace Inventory\Test\Unit\Core;

use Inventory\Core\Exception\FileMissing;
use Inventory\Core\Settings;
use Inventory\Test\Framework\BaseTestCase;

/**
 * SettingsTest Class
 *
 * @covers \Inventory\Core\Settings
 *
 * @group Framework
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
    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new Settings(null);
    }

    /**
     * Test object is initialized
     *
     * @throws \ReflectionException
     */
    public function testObjectInitializedWithDefaultConfigFile()
    {
        self::assertInstanceOf(Settings::class, $this->sut);
        self::assertSame($this->sut::DEFAULT_CONFIG_FILE, $this->getProtectedProperty($this->sut, 'configFile'));
    }

    /**
     * Test object is initialized with default config file override
     *
     * @throws \ReflectionException
     */
    public function testObjectInitializedWithDefaultConfigFileOverride()
    {
        $this->sut = new Settings('alter config');
        self::assertInstanceOf(Settings::class, $this->sut);
        self::assertSame('alter config', $this->getProtectedProperty($this->sut, 'configFile'));
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
     * Test load config falls back to default
     *
     * @throws \Inventory\Core\Exception\FileMissing
     * @throws \ReflectionException
     */
    public function testLoadConfigFallsBackToDefault()
    {
        // Load test config file
        $this->sut = new Settings(ROOT.'/../tests/unit/Core/SettingsTestConfigFileA.php');
        $this->sut->loadConfigFile();

        // Test
        $expected = include 'SettingsTestConfigFileA.php';
        $actual = $this->getProtectedProperty($this->sut, 'settings');
        self::assertSame($expected, $actual);
    }

    /**
     * Test File Missing error
     *
     * @throws \Inventory\Core\Exception\FileMissing
     */
    public function testLoadDefaultsThrowsFileNotFoundError()
    {
        $this->sut = new Settings('NON_EXISTENT_CONFIG_FILE');
        $this->expectException(FileMissing::class);
        $this->sut->loadConfigFile();
    }

    /**
     * Test configs are not overwritten
     *
     * @throws \Inventory\Core\Exception\FileMissing
     * @throws \ReflectionException
     */
    public function testLoadConfigNotWritesSettingsOver()
    {
        // Load test config files
        $this->sut = new Settings();
        $this->sut->loadConfigFile(ROOT.'/../tests/unit/Core/SettingsTestConfigFileA.php');
        $this->sut->loadConfigFile(ROOT.'/../tests/unit/Core/SettingsTestConfigFileB.php');

        $expected_a = include 'SettingsTestConfigFileA.php';
        $expected_b = include 'SettingsTestConfigFileB.php';
        $expected = (array_merge($expected_a, $expected_b));
        $actual = $this->getProtectedProperty($this->sut, 'settings');

        self::assertSame($expected, $actual);
    }
}
