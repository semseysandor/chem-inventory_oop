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

class CopyrightElementTest extends \PHPUnit\Framework\TestCase {
    /**
     * @var DOMDocument
     */
    private $dom;

    /**
     * @var CopyrightElement
     */
    private $copyright;

    protected function setUp() {
        $this->dom = new DOMDocument();
        $this->dom->loadXML('<?xml version="1.0" ?><copyright xmlns="https://phar.io/xml/manifest/1.0" />');
        $this->copyright = new CopyrightElement($this->dom->documentElement);
    }

    public function testThrowsExceptionWhenGetAuthroElementsIsCalledButNodesAreMissing() {
        $this->expectException(ManifestElementException::class);
        $this->copyright->getAuthorElements();
    }

    public function testThrowsExceptionWhenGetLicenseElementIsCalledButNodeIsMissing() {
        $this->expectException(ManifestElementException::class);
        $this->copyright->getLicenseElement();
    }

    public function testGetAuthorElementsReturnsAuthorElementCollection() {
        $this->dom->documentElement->appendChild(
            $this->dom->createElementNS('https://phar.io/xml/manifest/1.0', 'author')
        );
        $this->assertInstanceOf(
            AuthorElementCollection::class, $this->copyright->getAuthorElements()
        );
    }

    public function testGetLicenseElementReturnsLicenseElement() {
        $this->dom->documentElement->appendChild(
            $this->dom->createElementNS('https://phar.io/xml/manifest/1.0', 'license')
        );
        $this->assertInstanceOf(
            LicenseElement::class, $this->copyright->getLicenseElement()
        );
    }

}
