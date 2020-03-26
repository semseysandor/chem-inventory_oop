<?php
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

namespace PharIo\Manifest;

use DOMDocument;

class PhpElementTest extends \PHPUnit\Framework\TestCase {
    /**
     * @var DOMDocument
     */
    private $dom;

    /**
     * @var PhpElement
     */
    private $php;

    protected function setUp() {
        $this->dom = new DOMDocument();
        $this->dom->loadXML('<?xml version="1.0" ?><php xmlns="https://phar.io/xml/manifest/1.0" version="^5.6 || ^7.0" />');
        $this->php = new PhpElement($this->dom->documentElement);
    }

    public function testVersionConstraintCanBeRetrieved() {
        $this->assertEquals('^5.6 || ^7.0', $this->php->getVersion());
    }

    public function testHasExtElementsReturnsFalseWhenNoExtensionsAreRequired() {
        $this->assertFalse($this->php->hasExtElements());
    }

    public function testHasExtElementsReturnsTrueWhenExtensionsAreRequired() {
        $this->addExtElement();
        $this->assertTrue($this->php->hasExtElements());
    }

    public function testGetExtElementsReturnsExtElementCollection() {
        $this->addExtElement();
        $this->assertInstanceOf(ExtElementCollection::class, $this->php->getExtElements());
    }

    private function addExtElement() {
        $this->dom->documentElement->appendChild(
            $this->dom->createElementNS('https://phar.io/xml/manifest/1.0', 'ext')
        );
    }

}
