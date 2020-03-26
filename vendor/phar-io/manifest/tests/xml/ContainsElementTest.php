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
use DOMElement;

class ContainsElementTest extends \PHPUnit\Framework\TestCase {
    /**
     * @var DOMElement
     */
    private $domElement;

    /**
     * @var ContainsElement
     */
    private $contains;

    protected function setUp() {
        $dom = new DOMDocument();
        $dom->loadXML('<?xml version="1.0" ?><php xmlns="https://phar.io/xml/manifest/1.0" name="phpunit/phpunit" version="5.6.5" type="application" />');
        $this->domElement = $dom->documentElement;
        $this->contains   = new ContainsElement($this->domElement);
    }

    public function testVersionCanBeRetrieved() {
        $this->assertEquals('5.6.5', $this->contains->getVersion());
    }

    public function testThrowsExceptionWhenVersionAttributeIsMissing() {
        $this->domElement->removeAttribute('version');
        $this->expectException(ManifestElementException::class);
        $this->contains->getVersion();
    }

    public function testNameCanBeRetrieved() {
        $this->assertEquals('phpunit/phpunit', $this->contains->getName());
    }

    public function testThrowsExceptionWhenNameAttributeIsMissing() {
        $this->domElement->removeAttribute('name');
        $this->expectException(ManifestElementException::class);
        $this->contains->getName();
    }

    public function testTypeCanBeRetrieved() {
        $this->assertEquals('application', $this->contains->getType());
    }

    public function testThrowsExceptionWhenTypeAttributeIsMissing() {
        $this->domElement->removeAttribute('type');
        $this->expectException(ManifestElementException::class);
        $this->contains->getType();
    }

    public function testGetExtensionElementReturnsExtensionElement() {
        $this->domElement->appendChild(
            $this->domElement->ownerDocument->createElementNS('https://phar.io/xml/manifest/1.0', 'extension')
        );
        $this->assertInstanceOf(ExtensionElement::class, $this->contains->getExtensionElement());
    }

}
