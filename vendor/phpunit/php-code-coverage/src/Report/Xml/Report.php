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

final class Report extends File
{
    public function __construct(string $name)
    {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" ?><phpunit xmlns="https://schema.phpunit.de/coverage/1.0"><file /></phpunit>');

        $contextNode = $dom->getElementsByTagNameNS(
            'https://schema.phpunit.de/coverage/1.0',
            'file'
        )->item(0);

        parent::__construct($contextNode);

        $this->setName($name);
    }

    public function asDom(): \DOMDocument
    {
        return $this->getDomDocument();
    }

    public function getFunctionObject($name): Method
    {
        $node = $this->getContextNode()->appendChild(
            $this->getDomDocument()->createElementNS(
                'https://schema.phpunit.de/coverage/1.0',
                'function'
            )
        );

        return new Method($node, $name);
    }

    public function getClassObject($name): Unit
    {
        return $this->getUnitObject('class', $name);
    }

    public function getTraitObject($name): Unit
    {
        return $this->getUnitObject('trait', $name);
    }

    public function getSource(): Source
    {
        $source = $this->getContextNode()->getElementsByTagNameNS(
            'https://schema.phpunit.de/coverage/1.0',
            'source'
        )->item(0);

        if (!$source) {
            $source = $this->getContextNode()->appendChild(
                $this->getDomDocument()->createElementNS(
                    'https://schema.phpunit.de/coverage/1.0',
                    'source'
                )
            );
        }

        return new Source($source);
    }

    private function setName($name): void
    {
        $this->getContextNode()->setAttribute('name', \basename($name));
        $this->getContextNode()->setAttribute('path', \dirname($name));
    }

    private function getUnitObject($tagName, $name): Unit
    {
        $node = $this->getContextNode()->appendChild(
            $this->getDomDocument()->createElementNS(
                'https://schema.phpunit.de/coverage/1.0',
                $tagName
            )
        );

        return new Unit($node, $name);
    }
}
