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
namespace SebastianBergmann\CodeCoverage\Report\Xml;

use SebastianBergmann\CodeCoverage\RuntimeException;

final class Coverage
{
    /**
     * @var \XMLWriter
     */
    private $writer;

    /**
     * @var \DOMElement
     */
    private $contextNode;

    /**
     * @var bool
     */
    private $finalized = false;

    public function __construct(\DOMElement $context, string $line)
    {
        $this->contextNode = $context;

        $this->writer = new \XMLWriter();
        $this->writer->openMemory();
        $this->writer->startElementNS(null, $context->nodeName, 'https://schema.phpunit.de/coverage/1.0');
        $this->writer->writeAttribute('nr', $line);
    }

    /**
     * @throws RuntimeException
     */
    public function addTest(string $test): void
    {
        if ($this->finalized) {
            throw new RuntimeException('Coverage Report already finalized');
        }

        $this->writer->startElement('covered');
        $this->writer->writeAttribute('by', $test);
        $this->writer->endElement();
    }

    public function finalize(): void
    {
        $this->writer->endElement();

        $fragment = $this->contextNode->ownerDocument->createDocumentFragment();
        $fragment->appendXML($this->writer->outputMemory());

        $this->contextNode->parentNode->replaceChild(
            $fragment,
            $this->contextNode
        );

        $this->finalized = true;
    }
}
