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
namespace PHPUnit\Runner;

use PHPUnit\Framework\TestCase;
use PHPUnit\Util\PHP\AbstractPhpProcess;

/**
 * @medium
 */
final class PhptTestCaseTest extends TestCase
{
    private const EXPECT_CONTENT = <<<EOF
--TEST--
EXPECT test
--FILE--
<?php echo "Hello PHPUnit!"; ?>
--EXPECT--
Hello PHPUnit!
EOF;

    private const EXPECTF_CONTENT = <<<EOF
--TEST--
EXPECTF test
--FILE--
<?php echo "Hello PHPUnit!"; ?>
--EXPECTF--
Hello %s!
EOF;

    private const EXPECTREGEX_CONTENT = <<<EOF
--TEST--
EXPECTREGEX test
--FILE--
<?php echo "Hello PHPUnit!"; ?>
--EXPECTREGEX--
Hello [HPU]{4}[nit]{3}!
EOF;

    private const FILE_SECTION = <<<EOF
<?php echo "Hello PHPUnit!"; ?>

EOF;

    /**
     * @var string
     */
    private $dirname;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var PhptTestCase
     */
    private $testCase;

    /**
     * @var AbstractPhpProcess|\PHPUnit\Framework\MockObject\MockObject
     */
    private $phpProcess;

    protected function setUp(): void
    {
        $this->dirname  = \sys_get_temp_dir();
        $this->filename = $this->dirname . '/phpunit.phpt';
        \touch($this->filename);

        $this->phpProcess = $this->getMockForAbstractClass(AbstractPhpProcess::class, [], '', false);
        $this->testCase   = new PhptTestCase($this->filename, $this->phpProcess);
    }

    protected function tearDown(): void
    {
        @\unlink($this->filename);

        $this->phpProcess = null;
        $this->testCase   = null;
    }

    public function testAlwaysReportsNumberOfAssertionsIsOne(): void
    {
        $this->assertSame(1, $this->testCase->getNumAssertions());
    }

    public function testAlwaysReportsItDoesNotUseADataprovider(): void
    {
        $this->assertSame(false, $this->testCase->usesDataProvider());
    }

    public function testShouldRunFileSectionAsTest(): void
    {
        $this->setPhpContent($this->ensureCorrectEndOfLine(self::EXPECT_CONTENT));

        $fileSection = '<?php echo "Hello PHPUnit!"; ?>' . \PHP_EOL;

        $this->phpProcess
             ->expects($this->once())
             ->method('runJob')
             ->with($fileSection)
             ->will($this->returnValue(['stdout' => '', 'stderr' => '']));

        $this->testCase->run();
    }

    public function testRenderFileSection(): void
    {
        $this->setPhpContent($this->ensureCorrectEndOfLine(
            <<<EOF
--TEST--
Something to decribe it
--FILE--
<?php echo __DIR__ . __FILE__; ?>
--EXPECT--
Something
EOF
        ));

        $renderedCode = "<?php echo '" . $this->dirname . "' . '" . $this->filename . "'; ?>" . \PHP_EOL;

        $this->phpProcess
             ->expects($this->once())
             ->method('runJob')
             ->with($renderedCode)
             ->will($this->returnValue(['stdout' => '', 'stderr' => '']));

        $this->testCase->run();
    }

    public function testRenderSkipifSection(): void
    {
        $phptContent = self::EXPECT_CONTENT . \PHP_EOL;
        $phptContent .= '--SKIPIF--' . \PHP_EOL;
        $phptContent .= "<?php echo 'skip: ' . __FILE__; ?>" . \PHP_EOL;

        $this->setPhpContent($phptContent);

        $renderedCode = "<?php echo 'skip: ' . '" . $this->filename . "'; ?>" . \PHP_EOL;

        $this->phpProcess
             ->expects($this->at(0))
             ->method('runJob')
             ->with($renderedCode)
             ->will($this->returnValue(['stdout' => '', 'stderr' => '']));

        $this->testCase->run();
    }

    public function testShouldRunSkipifSectionWhenExists(): void
    {
        $skipifSection = '<?php /** Nothing **/ ?>' . \PHP_EOL;

        $phptContent = self::EXPECT_CONTENT . \PHP_EOL;
        $phptContent .= '--SKIPIF--' . \PHP_EOL;
        $phptContent .= $skipifSection;

        $this->setPhpContent($phptContent);

        $this->phpProcess
             ->expects($this->at(0))
             ->method('runJob')
             ->with($skipifSection)
             ->will($this->returnValue(['stdout' => '', 'stderr' => '']));

        $this->testCase->run();
    }

    public function testShouldNotRunTestSectionIfSkipifSectionReturnsOutputWithSkipWord(): void
    {
        $skipifSection = '<?php echo "skip: Reason"; ?>' . \PHP_EOL;

        $phptContent = self::EXPECT_CONTENT . \PHP_EOL;
        $phptContent .= '--SKIPIF--' . \PHP_EOL;
        $phptContent .= $skipifSection;

        $this->setPhpContent($phptContent);

        $this->phpProcess
             ->expects($this->once())
             ->method('runJob')
             ->with($skipifSection)
             ->will($this->returnValue(['stdout' => 'skip: Reason', 'stderr' => '']));

        $this->testCase->run();
    }

    public function testShouldRunCleanSectionWhenDefined(): void
    {
        $cleanSection = '<?php unlink("/tmp/something"); ?>' . \PHP_EOL;

        $phptContent = self::EXPECT_CONTENT . \PHP_EOL;
        $phptContent .= '--CLEAN--' . \PHP_EOL;
        $phptContent .= $cleanSection;

        $this->setPhpContent($phptContent);

        $this->phpProcess
             ->expects($this->at(1))
             ->method('runJob')
             ->with($cleanSection);

        $this->testCase->run();
    }

    public function testShouldSkipTestWhenPhptFileIsEmpty(): void
    {
        $this->setPhpContent('');

        $result = $this->testCase->run();
        $this->assertCount(1, $result->skipped());
        $this->assertSame('Invalid PHPT file', $result->skipped()[0]->thrownException()->getMessage());
    }

    public function testShouldSkipTestWhenFileSectionIsMissing(): void
    {
        $this->setPhpContent(
            <<<EOF
--TEST--
Something to describe it
--EXPECT--
Something
EOF
        );

        $result = $this->testCase->run();

        $this->assertCount(1, $result->skipped());
        $this->assertSame('Invalid PHPT file', $result->skipped()[0]->thrownException()->getMessage());
    }

    public function testShouldSkipTestWhenThereIsNoExpecOrExpectifOrExpecregexSectionInPhptFile(): void
    {
        $this->setPhpContent(
            <<<EOF
--TEST--
Something to describe it
--FILE--
<?php declare(strict_types=1);
echo "Hello world!\n";
?>
EOF
        );

        $result = $this->testCase->run();

        $this->assertCount(1, $result->skipped());
        $skipMessage = $result->skipped()[0]->thrownException()->getMessage();
        $this->assertSame('Invalid PHPT file', $skipMessage);
    }

    public function testShouldSkipTestWhenSectionHeaderIsMalformed(): void
    {
        $this->setPhpContent(
            <<<EOF
----
--TEST--
This is not going to work out
--EXPECT--
Tears and misery
EOF
        );

        $result = $this->testCase->run();

        $this->assertCount(1, $result->skipped());
        $skipMessage = $result->skipped()[0]->thrownException()->getMessage();
        $this->assertSame('Invalid PHPT file: empty section header', $skipMessage);
    }

    public function testShouldValidateExpectSession(): void
    {
        $this->setPhpContent(self::EXPECT_CONTENT);

        $this->phpProcess
             ->expects($this->once())
             ->method('runJob')
             ->with(self::FILE_SECTION)
             ->will($this->returnValue(['stdout' => 'Hello PHPUnit!', 'stderr' => '']));

        $result = $this->testCase->run();

        $this->assertTrue($result->wasSuccessful());
    }

    public function testShouldValidateExpectfSession(): void
    {
        $this->setPhpContent(self::EXPECTF_CONTENT);

        $this->phpProcess
             ->expects($this->once())
             ->method('runJob')
             ->with(self::FILE_SECTION)
             ->will($this->returnValue(['stdout' => 'Hello PHPUnit!', 'stderr' => '']));

        $result = $this->testCase->run();

        $this->assertTrue($result->wasSuccessful());
    }

    public function testShouldValidateExpectregexSession(): void
    {
        $this->setPhpContent(self::EXPECTREGEX_CONTENT);

        $this->phpProcess
             ->expects($this->once())
             ->method('runJob')
             ->with(self::FILE_SECTION)
             ->will($this->returnValue(['stdout' => 'Hello PHPUnit!', 'stderr' => '']));

        $result = $this->testCase->run();

        $this->assertTrue($result->wasSuccessful());
    }

    /**
     * Defines the content of the current PHPT test.
     *
     * @param string $content
     */
    private function setPhpContent($content): void
    {
        \file_put_contents($this->filename, $content);
    }

    /**
     * Ensures the correct line ending is used for comparison
     *
     * @param string $content
     *
     * @return string
     */
    private function ensureCorrectEndOfLine($content)
    {
        return \strtr(
            $content,
            [
                "\r\n" => \PHP_EOL,
                "\r"   => \PHP_EOL,
                "\n"   => \PHP_EOL,
            ]
        );
    }
}
