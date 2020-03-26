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
namespace PHPUnit\Runner\Filter;

use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\WarningTestCase;
use PHPUnit\Util\RegularExpression;
use RecursiveFilterIterator;
use RecursiveIterator;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class NameFilterIterator extends RecursiveFilterIterator
{
    /**
     * @var string
     */
    private $filter;

    /**
     * @var int
     */
    private $filterMin;

    /**
     * @var int
     */
    private $filterMax;

    /**
     * @throws \Exception
     */
    public function __construct(RecursiveIterator $iterator, string $filter)
    {
        parent::__construct($iterator);

        $this->setFilter($filter);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function accept(): bool
    {
        $test = $this->getInnerIterator()->current();

        if ($test instanceof TestSuite) {
            return true;
        }

        $tmp = \PHPUnit\Util\Test::describe($test);

        if ($test instanceof WarningTestCase) {
            $name = $test->getMessage();
        } elseif ($tmp[0] !== '') {
            $name = \implode('::', $tmp);
        } else {
            $name = $tmp[1];
        }

        $accepted = @\preg_match($this->filter, $name, $matches);

        if ($accepted && isset($this->filterMax)) {
            $set      = \end($matches);
            $accepted = $set >= $this->filterMin && $set <= $this->filterMax;
        }

        return (bool) $accepted;
    }

    /**
     * @throws \Exception
     */
    private function setFilter(string $filter): void
    {
        if (RegularExpression::safeMatch($filter, '') === false) {
            // Handles:
            //  * testAssertEqualsSucceeds#4
            //  * testAssertEqualsSucceeds#4-8
            if (\preg_match('/^(.*?)#(\d+)(?:-(\d+))?$/', $filter, $matches)) {
                if (isset($matches[3]) && $matches[2] < $matches[3]) {
                    $filter = \sprintf(
                        '%s.*with data set #(\d+)$',
                        $matches[1]
                    );

                    $this->filterMin = $matches[2];
                    $this->filterMax = $matches[3];
                } else {
                    $filter = \sprintf(
                        '%s.*with data set #%s$',
                        $matches[1],
                        $matches[2]
                    );
                }
            } // Handles:
            //  * testDetermineJsonError@JSON_ERROR_NONE
            //  * testDetermineJsonError@JSON.*
            elseif (\preg_match('/^(.*?)@(.+)$/', $filter, $matches)) {
                $filter = \sprintf(
                    '%s.*with data set "%s"$',
                    $matches[1],
                    $matches[2]
                );
            }

            // Escape delimiters in regular expression. Do NOT use preg_quote,
            // to keep magic characters.
            $filter = \sprintf('/%s/i', \str_replace(
                '/',
                '\\/',
                $filter
            ));
        }

        $this->filter = $filter;
    }
}
