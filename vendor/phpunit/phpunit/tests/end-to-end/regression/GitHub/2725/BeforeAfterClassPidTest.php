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
namespace Issue2725;

use PHPUnit\Framework\TestCase;

/**
 * @runClassInSeparateProcess
 */
class BeforeAfterClassPidTest extends TestCase
{
    public const PID_VARIABLE = 'current_pid';

    /**
     * @beforeClass
     */
    public static function showPidBefore(): void
    {
        $GLOBALS[static::PID_VARIABLE] = \getmypid();
    }

    /**
     * @afterClass
     */
    public static function showPidAfter(): void
    {
        if ($GLOBALS[static::PID_VARIABLE] - \getmypid() !== 0) {
            print "\n@afterClass output - PID difference should be zero!";
        }

        unset($GLOBALS[static::PID_VARIABLE]);
    }

    public function testMethod1WithItsBeforeAndAfter(): void
    {
        $this->assertEquals($GLOBALS[static::PID_VARIABLE], \getmypid());
    }

    public function testMethod2WithItsBeforeAndAfter(): void
    {
        $this->assertEquals($GLOBALS[static::PID_VARIABLE], \getmypid());
    }
}
