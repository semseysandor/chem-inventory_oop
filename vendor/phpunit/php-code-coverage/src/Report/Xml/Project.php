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

final class Project extends Node
{
    public function __construct(string $directory)
    {
        $this->init();
        $this->setProjectSourceDirectory($directory);
    }

    public function getProjectSourceDirectory(): string
    {
        return $this->getContextNode()->getAttribute('source');
    }

    public function getBuildInformation(): BuildInformation
    {
        $buildNode = $this->getDom()->getElementsByTagNameNS(
            'https://schema.phpunit.de/coverage/1.0',
            'build'
        )->item(0);

        if (!$buildNode) {
            $buildNode = $this->getDom()->documentElement->appendChild(
                $this->getDom()->createElementNS(
                    'https://schema.phpunit.de/coverage/1.0',
                    'build'
                )
            );
        }

        return new BuildInformation($buildNode);
    }

    public function getTests(): Tests
    {
        $testsNode = $this->getContextNode()->getElementsByTagNameNS(
            'https://schema.phpunit.de/coverage/1.0',
            'tests'
        )->item(0);

        if (!$testsNode) {
            $testsNode = $this->getContextNode()->appendChild(
                $this->getDom()->createElementNS(
                    'https://schema.phpunit.de/coverage/1.0',
                    'tests'
                )
            );
        }

        return new Tests($testsNode);
    }

    public function asDom(): \DOMDocument
    {
        return $this->getDom();
    }

    private function init(): void
    {
        $dom = new \DOMDocument;
        $dom->loadXML('<?xml version="1.0" ?><phpunit xmlns="https://schema.phpunit.de/coverage/1.0"><build/><project/></phpunit>');

        $this->setContextNode(
            $dom->getElementsByTagNameNS(
                'https://schema.phpunit.de/coverage/1.0',
                'project'
            )->item(0)
        );
    }

    private function setProjectSourceDirectory(string $name): void
    {
        $this->getContextNode()->setAttribute('source', $name);
    }
}
