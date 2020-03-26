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
use PHPUnit\Framework\TestCase;

class ClonedDependencyTest extends TestCase
{
    private static $dependency;

    public static function setUpBeforeClass(): void
    {
        self::$dependency = new stdClass;
    }

    public function testOne()
    {
        $this->assertTrue(true);

        return self::$dependency;
    }

    /**
     * @depends testOne
     */
    public function testTwo($dependency): void
    {
        $this->assertSame(self::$dependency, $dependency);
    }

    /**
     * @depends !clone testOne
     */
    public function testThree($dependency): void
    {
        $this->assertSame(self::$dependency, $dependency);
    }

    /**
     * @depends clone testOne
     */
    public function testFour($dependency): void
    {
        $this->assertNotSame(self::$dependency, $dependency);
    }

    /**
     * @depends !shallowClone testOne
     */
    public function testFive($dependency): void
    {
        $this->assertSame(self::$dependency, $dependency);
    }

    /**
     * @depends shallowClone testOne
     */
    public function testSix($dependency): void
    {
        $this->assertNotSame(self::$dependency, $dependency);
    }
}
