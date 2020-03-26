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
 * @covers \SebastianBergmann\Environment\Runtime
 */
final class RuntimeTest extends TestCase
{
    /**
     * @var \SebastianBergmann\Environment\Runtime
     */
    private $env;

    protected function setUp(): void
    {
        $this->env = new Runtime;
    }

    /**
     * @requires extension xdebug
     */
    public function testCanCollectCodeCoverageWhenXdebugExtensionIsEnabled(): void
    {
        $this->assertTrue($this->env->canCollectCodeCoverage());
    }

    /**
     * @requires extension pcov
     */
    public function testCanCollectCodeCoverageWhenPcovExtensionIsEnabled(): void
    {
        $this->assertTrue($this->env->canCollectCodeCoverage());
    }

    public function testCanCollectCodeCoverageWhenRunningOnPhpdbg(): void
    {
        $this->markTestSkippedWhenNotRunningOnPhpdbg();

        $this->assertTrue($this->env->canCollectCodeCoverage());
    }

    public function testBinaryCanBeRetrieved(): void
    {
        $this->assertNotEmpty($this->env->getBinary());
    }

    /**
     * @requires PHP
     */
    public function testIsHhvmReturnsFalseWhenRunningOnPhp(): void
    {
        $this->assertFalse($this->env->isHHVM());
    }

    /**
     * @requires PHP
     */
    public function testIsPhpReturnsTrueWhenRunningOnPhp(): void
    {
        $this->markTestSkippedWhenRunningOnPhpdbg();

        $this->assertTrue($this->env->isPHP());
    }

    /**
     * @requires extension pcov
     */
    public function testPCOVCanBeDetected(): void
    {
        $this->assertTrue($this->env->hasPCOV());
    }

    public function testPhpdbgCanBeDetected(): void
    {
        $this->markTestSkippedWhenNotRunningOnPhpdbg();

        $this->assertTrue($this->env->hasPHPDBGCodeCoverage());
    }

    /**
     * @requires extension xdebug
     */
    public function testXdebugCanBeDetected(): void
    {
        $this->markTestSkippedWhenRunningOnPhpdbg();

        $this->assertTrue($this->env->hasXdebug());
    }

    public function testNameAndVersionCanBeRetrieved(): void
    {
        $this->assertNotEmpty($this->env->getNameWithVersion());
    }

    public function testGetNameReturnsPhpdbgWhenRunningOnPhpdbg(): void
    {
        $this->markTestSkippedWhenNotRunningOnPhpdbg();

        $this->assertSame('PHPDBG', $this->env->getName());
    }

    /**
     * @requires PHP
     */
    public function testGetNameReturnsPhpdbgWhenRunningOnPhp(): void
    {
        $this->markTestSkippedWhenRunningOnPhpdbg();

        $this->assertSame('PHP', $this->env->getName());
    }

    public function testNameAndCodeCoverageDriverCanBeRetrieved(): void
    {
        $this->assertNotEmpty($this->env->getNameWithVersionAndCodeCoverageDriver());
    }

    /**
     * @requires PHP
     */
    public function testGetVersionReturnsPhpVersionWhenRunningPhp(): void
    {
        $this->assertSame(\PHP_VERSION, $this->env->getVersion());
    }

    /**
     * @requires PHP
     */
    public function testGetVendorUrlReturnsPhpDotNetWhenRunningPhp(): void
    {
        $this->assertSame('https://secure.php.net/', $this->env->getVendorUrl());
    }

    private function markTestSkippedWhenNotRunningOnPhpdbg(): void
    {
        if ($this->isRunningOnPhpdbg()) {
            return;
        }

        $this->markTestSkipped('PHPDBG is required.');
    }

    private function markTestSkippedWhenRunningOnPhpdbg(): void
    {
        if (!$this->isRunningOnPhpdbg()) {
            return;
        }

        $this->markTestSkipped('Cannot run on PHPDBG');
    }

    private function isRunningOnPhpdbg(): bool
    {
        return \PHP_SAPI === 'phpdbg';
    }
}
