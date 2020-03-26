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
namespace PHPUnit\Framework\Constraint;

use SebastianBergmann\Diff\Differ;

/**
 * ...
 */
final class StringMatchesFormatDescription extends RegularExpression
{
    /**
     * @var string
     */
    private $string;

    public function __construct(string $string)
    {
        parent::__construct(
            $this->createPatternFromFormat(
                $this->convertNewlines($string)
            )
        );

        $this->string = $string;
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other value or object to evaluate
     */
    protected function matches($other): bool
    {
        return parent::matches(
            $this->convertNewlines($other)
        );
    }

    protected function failureDescription($other): string
    {
        return 'string matches format description';
    }

    protected function additionalFailureDescription($other): string
    {
        $from = \explode("\n", $this->string);
        $to   = \explode("\n", $this->convertNewlines($other));

        foreach ($from as $index => $line) {
            if (isset($to[$index]) && $line !== $to[$index]) {
                $line = $this->createPatternFromFormat($line);

                if (\preg_match($line, $to[$index]) > 0) {
                    $from[$index] = $to[$index];
                }
            }
        }

        $this->string = \implode("\n", $from);
        $other        = \implode("\n", $to);

        return (new Differ("--- Expected\n+++ Actual\n"))->diff($this->string, $other);
    }

    private function createPatternFromFormat(string $string): string
    {
        $string = \strtr(
            \preg_quote($string, '/'),
            [
                '%%' => '%',
                '%e' => '\\' . \DIRECTORY_SEPARATOR,
                '%s' => '[^\r\n]+',
                '%S' => '[^\r\n]*',
                '%a' => '.+',
                '%A' => '.*',
                '%w' => '\s*',
                '%i' => '[+-]?\d+',
                '%d' => '\d+',
                '%x' => '[0-9a-fA-F]+',
                '%f' => '[+-]?\.?\d+\.?\d*(?:[Ee][+-]?\d+)?',
                '%c' => '.',
            ]
        );

        return '/^' . $string . '$/s';
    }

    private function convertNewlines($text): string
    {
        return \preg_replace('/\r\n/', "\n", $text);
    }
}
