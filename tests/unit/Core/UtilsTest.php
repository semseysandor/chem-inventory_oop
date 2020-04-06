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

use Inventory\Core\Utils;
use Inventory\Test\Framework\BaseTestCase;

/**
 * UtilsTest Class
 *
 * @covers \Inventory\Core\Utils
 *
 * @group framework
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class UtilsTest extends BaseTestCase
{
    /**
     * Test if correct path is returned
     *
     * @dataProvider provideClassAndExpectedPath
     *
     * @param string $class Class name
     * @param string $path Path
     */
    public function testCorrectPathReturned(string $class, string $path)
    {
        self::assertSame($path, Utils::getPathFromClass($class));
    }

    /**
     * Provides class & path
     *
     * @return array
     */
    public function provideClassAndExpectedPath()
    {
        return [
          'Non-existent class' => ['NON_EXIST', ''],
          'Real inventory class' => ['Inventory\Core\Utils', 'Core/Utils',],
          'General class' => ['PHPUnit\Framework\TestCase', 'Framework/TestCase'],
          'General class with leading backslash' => ['\PHPUnit\Framework\TestCase', 'Framework/TestCase'],
        ];
    }
}
