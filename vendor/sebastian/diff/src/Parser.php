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

namespace SebastianBergmann\Diff;

/**
 * Unified diff parser.
 */
final class Parser
{
    /**
     * @param string $string
     *
     * @return Diff[]
     */
    public function parse(string $string): array
    {
        $lines = \preg_split('(\r\n|\r|\n)', $string);

        if (!empty($lines) && $lines[\count($lines) - 1] === '') {
            \array_pop($lines);
        }

        $lineCount = \count($lines);
        $diffs     = [];
        $diff      = null;
        $collected = [];

        for ($i = 0; $i < $lineCount; ++$i) {
            if (\preg_match('(^---\\s+(?P<file>\\S+))', $lines[$i], $fromMatch) &&
                \preg_match('(^\\+\\+\\+\\s+(?P<file>\\S+))', $lines[$i + 1], $toMatch)) {
                if ($diff !== null) {
                    $this->parseFileDiff($diff, $collected);

                    $diffs[]   = $diff;
                    $collected = [];
                }

                $diff = new Diff($fromMatch['file'], $toMatch['file']);

                ++$i;
            } else {
                if (\preg_match('/^(?:diff --git |index [\da-f\.]+|[+-]{3} [ab])/', $lines[$i])) {
                    continue;
                }

                $collected[] = $lines[$i];
            }
        }

        if ($diff !== null && \count($collected)) {
            $this->parseFileDiff($diff, $collected);

            $diffs[] = $diff;
        }

        return $diffs;
    }

    private function parseFileDiff(Diff $diff, array $lines): void
    {
        $chunks = [];
        $chunk  = null;

        foreach ($lines as $line) {
            if (\preg_match('/^@@\s+-(?P<start>\d+)(?:,\s*(?P<startrange>\d+))?\s+\+(?P<end>\d+)(?:,\s*(?P<endrange>\d+))?\s+@@/', $line, $match)) {
                $chunk = new Chunk(
                    (int) $match['start'],
                    isset($match['startrange']) ? \max(1, (int) $match['startrange']) : 1,
                    (int) $match['end'],
                    isset($match['endrange']) ? \max(1, (int) $match['endrange']) : 1
                );

                $chunks[]  = $chunk;
                $diffLines = [];

                continue;
            }

            if (\preg_match('/^(?P<type>[+ -])?(?P<line>.*)/', $line, $match)) {
                $type = Line::UNCHANGED;

                if ($match['type'] === '+') {
                    $type = Line::ADDED;
                } elseif ($match['type'] === '-') {
                    $type = Line::REMOVED;
                }

                $diffLines[] = new Line($type, $match['line']);

                if (null !== $chunk) {
                    $chunk->setLines($diffLines);
                }
            }
        }

        $diff->setChunks($chunks);
    }
}
