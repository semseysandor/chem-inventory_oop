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
namespace PHPUnit\Util\PHP;

use PHPUnit\Framework\TestCase;

/**
 * @small
 */
final class AbstractPhpProcessTest extends TestCase
{
    /**
     * @var AbstractPhpProcess|\PHPUnit\Framework\MockObject\MockObject
     */
    private $phpProcess;

    protected function setUp(): void
    {
        $this->phpProcess = $this->getMockForAbstractClass(AbstractPhpProcess::class);
    }

    protected function tearDown(): void
    {
        $this->phpProcess = null;
    }

    public function testShouldNotUseStderrRedirectionByDefault(): void
    {
        $this->assertFalse($this->phpProcess->useStderrRedirection());
    }

    public function testShouldDefinedIfUseStderrRedirection(): void
    {
        $this->phpProcess->setUseStderrRedirection(true);

        $this->assertTrue($this->phpProcess->useStderrRedirection());
    }

    public function testShouldDefinedIfDoNotUseStderrRedirection(): void
    {
        $this->phpProcess->setUseStderrRedirection(false);

        $this->assertFalse($this->phpProcess->useStderrRedirection());
    }

    public function testShouldUseGivenSettingsToCreateCommand(): void
    {
        $settings = [
            'allow_url_fopen=1',
            'auto_append_file=',
            'display_errors=1',
        ];

        $expectedCommandFormat  = '%s -d %callow_url_fopen=1%c -d %cauto_append_file=%c -d %cdisplay_errors=1%c%S';
        $actualCommand          = $this->phpProcess->getCommand($settings);

        $this->assertStringMatchesFormat($expectedCommandFormat, $actualCommand);
    }

    public function testShouldRedirectStderrToStdoutWhenDefined(): void
    {
        $this->phpProcess->setUseStderrRedirection(true);

        $expectedCommandFormat  = '%s 2>&1';
        $actualCommand          = $this->phpProcess->getCommand([]);

        $this->assertStringMatchesFormat($expectedCommandFormat, $actualCommand);
    }

    public function testShouldUseArgsToCreateCommand(): void
    {
        $this->phpProcess->setArgs('foo=bar');

        $expectedCommandFormat  = '%s foo=bar';
        $actualCommand          = $this->phpProcess->getCommand([]);

        $this->assertStringMatchesFormat($expectedCommandFormat, $actualCommand);
    }

    public function testShouldHaveFileToCreateCommand(): void
    {
        $expectedCommandFormat     = '%s %cfile.php%c';
        $actualCommand             = $this->phpProcess->getCommand([], 'file.php');

        $this->assertStringMatchesFormat($expectedCommandFormat, $actualCommand);
    }

    public function testStdinGetterAndSetter(): void
    {
        $this->phpProcess->setStdin('foo');

        $this->assertEquals('foo', $this->phpProcess->getStdin());
    }

    public function testArgsGetterAndSetter(): void
    {
        $this->phpProcess->setArgs('foo=bar');

        $this->assertEquals('foo=bar', $this->phpProcess->getArgs());
    }

    public function testEnvGetterAndSetter(): void
    {
        $this->phpProcess->setEnv(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $this->phpProcess->getEnv());
    }

    public function testTimeoutGetterAndSetter(): void
    {
        $this->phpProcess->setTimeout(30);

        $this->assertEquals(30, $this->phpProcess->getTimeout());
    }
}
