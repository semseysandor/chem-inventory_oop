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

namespace SebastianBergmann\Diff\Output;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Diff\Differ;

/**
 * @covers SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder
 *
 * @uses SebastianBergmann\Diff\Differ
 * @uses SebastianBergmann\Diff\Output\AbstractChunkOutputBuilder
 * @uses SebastianBergmann\Diff\TimeEfficientLongestCommonSubsequenceCalculator
 */
final class UnifiedDiffOutputBuilderTest extends TestCase
{
    /**
     * @param string $expected
     * @param string $from
     * @param string $to
     * @param string $header
     *
     * @dataProvider headerProvider
     */
    public function testCustomHeaderCanBeUsed(string $expected, string $from, string $to, string $header): void
    {
        $differ = new Differ(new UnifiedDiffOutputBuilder($header));

        $this->assertSame(
            $expected,
            $differ->diff($from, $to)
        );
    }

    public function headerProvider(): array
    {
        return [
            [
                "CUSTOM HEADER\n@@ @@\n-a\n+b\n",
                'a',
                'b',
                'CUSTOM HEADER',
            ],
            [
                "CUSTOM HEADER\n@@ @@\n-a\n+b\n",
                'a',
                'b',
                "CUSTOM HEADER\n",
            ],
            [
                "CUSTOM HEADER\n\n@@ @@\n-a\n+b\n",
                'a',
                'b',
                "CUSTOM HEADER\n\n",
            ],
            [
                "@@ @@\n-a\n+b\n",
                'a',
                'b',
                '',
            ],
        ];
    }

    /**
     * @param string $expected
     * @param string $from
     * @param string $to
     *
     * @dataProvider provideDiffWithLineNumbers
     */
    public function testDiffWithLineNumbers($expected, $from, $to): void
    {
        $differ = new Differ(new UnifiedDiffOutputBuilder("--- Original\n+++ New\n", true));
        $this->assertSame($expected, $differ->diff($from, $to));
    }

    public function provideDiffWithLineNumbers(): array
    {
        return UnifiedDiffOutputBuilderDataProvider::provideDiffWithLineNumbers();
    }
}
