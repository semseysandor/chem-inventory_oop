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
namespace SebastianBergmann\GlobalState;

/**
 * Exports parts of a Snapshot as PHP code.
 */
final class CodeExporter
{
    public function constants(Snapshot $snapshot): string
    {
        $result = '';

        foreach ($snapshot->constants() as $name => $value) {
            $result .= \sprintf(
                'if (!defined(\'%s\')) define(\'%s\', %s);' . "\n",
                $name,
                $name,
                $this->exportVariable($value)
            );
        }

        return $result;
    }

    public function globalVariables(Snapshot $snapshot): string
    {
        $result = '$GLOBALS = [];' . \PHP_EOL;

        foreach ($snapshot->globalVariables() as $name => $value) {
            $result .= \sprintf(
                '$GLOBALS[%s] = %s;' . \PHP_EOL,
                $this->exportVariable($name),
                $this->exportVariable($value)
            );
        }

        return $result;
    }

    public function iniSettings(Snapshot $snapshot): string
    {
        $result = '';

        foreach ($snapshot->iniSettings() as $key => $value) {
            $result .= \sprintf(
                '@ini_set(%s, %s);' . "\n",
                $this->exportVariable($key),
                $this->exportVariable($value)
            );
        }

        return $result;
    }

    private function exportVariable($variable): string
    {
        if (\is_scalar($variable) || null === $variable ||
            (\is_array($variable) && $this->arrayOnlyContainsScalars($variable))) {
            return \var_export($variable, true);
        }

        return 'unserialize(' . \var_export(\serialize($variable), true) . ')';
    }

    private function arrayOnlyContainsScalars(array $array): bool
    {
        $result = true;

        foreach ($array as $element) {
            if (\is_array($element)) {
                $result = $this->arrayOnlyContainsScalars($element);
            } elseif (!\is_scalar($element) && null !== $element) {
                $result = false;
            }

            if ($result === false) {
                break;
            }
        }

        return $result;
    }
}
