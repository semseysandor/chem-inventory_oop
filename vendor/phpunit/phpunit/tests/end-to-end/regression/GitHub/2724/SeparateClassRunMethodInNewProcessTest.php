<?php declare(strict_types=1);
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

/**
 * @runClassInSeparateProcess
 */
class SeparateClassRunMethodInNewProcessTest extends PHPUnit\Framework\TestCase
{
    public const PROCESS_ID_FILE_PATH = __DIR__ . '/parent_process_id.txt';

    public const INITIAL_MASTER_PID   = 0;

    public const INITIAL_PID1         = 1;

    public static $masterPid = self::INITIAL_MASTER_PID;

    public static $pid1      = self::INITIAL_PID1;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        if (\file_exists(self::PROCESS_ID_FILE_PATH)) {
            static::$masterPid = (int) \file_get_contents(self::PROCESS_ID_FILE_PATH);
        }
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        if (\file_exists(self::PROCESS_ID_FILE_PATH)) {
            \unlink(self::PROCESS_ID_FILE_PATH);
        }
    }

    public function testMethodShouldGetDifferentPidThanMaster(): void
    {
        static::$pid1 = \getmypid();

        $this->assertNotEquals(self::INITIAL_PID1, static::$pid1);
        $this->assertNotEquals(self::INITIAL_MASTER_PID, static::$masterPid);

        $this->assertNotEquals(static::$pid1, static::$masterPid);
    }
}
