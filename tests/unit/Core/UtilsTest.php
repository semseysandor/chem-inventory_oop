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

    /**
     * Test Input sanitization
     *
     * @dataProvider provideInputs
     *
     * @param $mode
     * @param $input
     * @param $expected
     */
    public function testSanitizeString($mode, $input, $expected)
    {
        self::assertSame($expected, Utils::sanitizeString($input, $mode));
    }

    /**
     * Provides inputs
     *
     * @return array
     */
    public function provideInputs()
    {
        return [
          'null' => [null, "", ""],
          'word' => ['word', '  <script>te st</script>@#]["!/?.,>><%  ', 'test'],
          'extended' => ['extended', '  <script>"monkey worlds"</script>@#]["!/?.,>><%  ', 'monkey worlds.,>><%'],
          'real' => ['extended', ' puriss., <99.5%', 'puriss., <99.5%'],
        ];
    }

    /**
     * Test ID sanitization
     *
     * @dataProvider provideID
     *
     * @param $input
     * @param $expected
     */
    public function testSanitizeId($input, $expected)
    {
        self::assertSame($expected, Utils::sanitizeID($input));
    }

    /**
     * Provides ID
     *
     * @return array
     */
    public function provideId()
    {
        return [
          'null' => ["", null],
          'string' => ['abc', null],
          'negative' => ['-5', null],
          'positive' => ['56', 56],
          'mixed' => ['11abj', 11],
        ];
    }
}
