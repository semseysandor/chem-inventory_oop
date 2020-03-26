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
namespace SebastianBergmann\Environment;

use PHPUnit\Framework\TestCase;

/**
 * @covers \SebastianBergmann\Environment\OperatingSystem
 */
final class OperatingSystemTest extends TestCase
{
    /**
     * @var \SebastianBergmann\Environment\OperatingSystem
     */
    private $os;

    protected function setUp(): void
    {
        $this->os = new OperatingSystem;
    }

    /**
     * @requires OS Linux
     */
    public function testFamilyCanBeRetrieved(): void
    {
        $this->assertEquals('Linux', $this->os->getFamily());
    }

    /**
     * @requires OS Darwin
     */
    public function testFamilyReturnsDarwinWhenRunningOnDarwin(): void
    {
        $this->assertEquals('Darwin', $this->os->getFamily());
    }

    /**
     * @requires OS Windows
     */
    public function testGetFamilyReturnsWindowsWhenRunningOnWindows(): void
    {
        $this->assertSame('Windows', $this->os->getFamily());
    }

    /**
     * @requires PHP 7.2.0
     */
    public function testGetFamilyReturnsPhpOsFamilyWhenRunningOnPhp72AndGreater(): void
    {
        $this->assertSame(\PHP_OS_FAMILY, $this->os->getFamily());
    }
}
