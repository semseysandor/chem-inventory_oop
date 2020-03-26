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
namespace PHPUnit\Util;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Runner\PhptTestCase;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class XmlTestListRenderer
{
    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function render(TestSuite $suite): string
    {
        $writer = new \XMLWriter;

        $writer->openMemory();
        $writer->setIndent(true);
        $writer->startDocument();
        $writer->startElement('tests');

        $currentTestCase = null;

        foreach (new \RecursiveIteratorIterator($suite->getIterator()) as $test) {
            if ($test instanceof TestCase) {
                if (\get_class($test) !== $currentTestCase) {
                    if ($currentTestCase !== null) {
                        $writer->endElement();
                    }

                    $writer->startElement('testCaseClass');
                    $writer->writeAttribute('name', \get_class($test));

                    $currentTestCase = \get_class($test);
                }

                $writer->startElement('testCaseMethod');
                $writer->writeAttribute('name', $test->getName(false));
                $writer->writeAttribute('groups', \implode(',', $test->getGroups()));

                if (!empty($test->getDataSetAsString(false))) {
                    $writer->writeAttribute(
                        'dataSet',
                        \str_replace(
                            ' with data set ',
                            '',
                            $test->getDataSetAsString(false)
                        )
                    );
                }

                $writer->endElement();
            } elseif ($test instanceof PhptTestCase) {
                if ($currentTestCase !== null) {
                    $writer->endElement();

                    $currentTestCase = null;
                }

                $writer->startElement('phptFile');
                $writer->writeAttribute('path', $test->getName());
                $writer->endElement();
            }
        }

        if ($currentTestCase !== null) {
            $writer->endElement();
        }

        $writer->endElement();

        return $writer->outputMemory();
    }
}
