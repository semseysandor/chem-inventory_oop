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

use SebastianBergmann\Diff\Differ;

/**
 * Builds a diff string representation in a loose unified diff format
 * listing only changes lines. Does not include line numbers.
 */
final class DiffOnlyOutputBuilder implements DiffOutputBuilderInterface
{
    /**
     * @var string
     */
    private $header;

    public function __construct(string $header = "--- Original\n+++ New\n")
    {
        $this->header = $header;
    }

    public function getDiff(array $diff): string
    {
        $buffer = \fopen('php://memory', 'r+b');

        if ('' !== $this->header) {
            \fwrite($buffer, $this->header);

            if ("\n" !== \substr($this->header, -1, 1)) {
                \fwrite($buffer, "\n");
            }
        }

        foreach ($diff as $diffEntry) {
            if ($diffEntry[1] === Differ::ADDED) {
                \fwrite($buffer, '+' . $diffEntry[0]);
            } elseif ($diffEntry[1] === Differ::REMOVED) {
                \fwrite($buffer, '-' . $diffEntry[0]);
            } elseif ($diffEntry[1] === Differ::DIFF_LINE_END_WARNING) {
                \fwrite($buffer, ' ' . $diffEntry[0]);

                continue; // Warnings should not be tested for line break, it will always be there
            } else { /* Not changed (old) 0 */
                continue; // we didn't write the non changs line, so do not add a line break either
            }

            $lc = \substr($diffEntry[0], -1);

            if ($lc !== "\n" && $lc !== "\r") {
                \fwrite($buffer, "\n"); // \No newline at end of file
            }
        }

        $diff = \stream_get_contents($buffer, -1, 0);
        \fclose($buffer);

        return $diff;
    }
}
