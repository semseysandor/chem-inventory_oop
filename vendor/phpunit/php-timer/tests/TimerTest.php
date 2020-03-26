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
namespace SebastianBergmann\Timer;

use PHPUnit\Framework\TestCase;

/**
 * @covers \SebastianBergmann\Timer\Timer
 */
final class TimerTest extends TestCase
{
    public function testCanBeStartedAndStopped(): void
    {
        $this->assertIsFloat(Timer::stop());
    }

    public function testCanFormatTimeSinceStartOfRequest(): void
    {
        $this->assertStringMatchesFormat('%f %s', Timer::timeSinceStartOfRequest());
    }

    /**
     * @backupGlobals enabled
     */
    public function testCanFormatSinceStartOfRequestWhenRequestTimeIsNotAvailableAsFloat(): void
    {
        if (isset($_SERVER['REQUEST_TIME_FLOAT'])) {
            unset($_SERVER['REQUEST_TIME_FLOAT']);
        }

        $this->assertStringMatchesFormat('%f %s', Timer::timeSinceStartOfRequest());
    }

    /**
     * @backupGlobals enabled
     */
    public function testCannotFormatTimeSinceStartOfRequestWhenRequestTimeIsNotAvailable(): void
    {
        if (isset($_SERVER['REQUEST_TIME_FLOAT'])) {
            unset($_SERVER['REQUEST_TIME_FLOAT']);
        }

        if (isset($_SERVER['REQUEST_TIME'])) {
            unset($_SERVER['REQUEST_TIME']);
        }

        $this->expectException(RuntimeException::class);

        Timer::timeSinceStartOfRequest();
    }

    public function testCanFormatResourceUsage(): void
    {
        $this->assertStringMatchesFormat('Time: %s, Memory: %f %s', Timer::resourceUsage());
    }

    /**
     * @dataProvider secondsProvider
     */
    public function testCanFormatSecondsAsString(string $string, float $seconds): void
    {
        $this->assertEquals($string, Timer::secondsToTimeString($seconds));
    }

    public function secondsProvider(): array
    {
        return [
            ['0 ms', 0],
            ['1 ms', .001],
            ['10 ms', .01],
            ['100 ms', .1],
            ['999 ms', .999],
            ['1 second', .9999],
            ['1 second', 1],
            ['2 seconds', 2],
            ['59.9 seconds', 59.9],
            ['59.99 seconds', 59.99],
            ['59.99 seconds', 59.999],
            ['1 minute', 59.9999],
            ['59 seconds', 59.001],
            ['59.01 seconds', 59.01],
            ['1 minute', 60],
            ['1.01 minutes', 61],
            ['2 minutes', 120],
            ['2.01 minutes', 121],
            ['59.99 minutes', 3599.9],
            ['59.99 minutes', 3599.99],
            ['59.99 minutes', 3599.999],
            ['1 hour', 3599.9999],
            ['59.98 minutes', 3599.001],
            ['59.98 minutes', 3599.01],
            ['1 hour', 3600],
            ['1 hour', 3601],
            ['1 hour', 3601.9],
            ['1 hour', 3601.99],
            ['1 hour', 3601.999],
            ['1 hour', 3601.9999],
            ['1.01 hours', 3659.9999],
            ['1.01 hours', 3659.001],
            ['1.01 hours', 3659.01],
            ['2 hours', 7199.9999],
        ];
    }

    /**
     * @dataProvider bytesProvider
     */
    public function testCanFormatBytesAsString(string $string, float $bytes): void
    {
        $this->assertEquals($string, Timer::bytesToString($bytes));
    }

    public function bytesProvider(): array
    {
        return [
            ['0 bytes', 0],
            ['1 byte', 1],
            ['1023 bytes', 1023],
            ['1.00 KB', 1024],
            ['1.50 KB', 1.5 * 1024],
            ['2.00 MB', 2 * 1048576],
            ['2.50 MB', 2.5 * 1048576],
            ['3.00 GB', 3 * 1073741824],
            ['3.50 GB', 3.5 * 1073741824],
        ];
    }
}
