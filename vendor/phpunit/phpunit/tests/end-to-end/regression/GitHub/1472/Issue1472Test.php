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
use PHPUnit\Framework\TestCase;

class Issue1472Test extends TestCase
{
    public function testAssertEqualXMLStructure(): void
    {
        $doc = new DOMDocument;
        $doc->loadXML('<root><label>text content</label></root>');

        $xpath = new DOMXPath($doc);

        $labelElement = $doc->getElementsByTagName('label')->item(0);

        $this->assertEquals(1, $xpath->evaluate('count(//label[text() = "text content"])'));

        $expectedElmt = $doc->createElement('label', 'text content');
        $this->assertEqualXMLStructure($expectedElmt, $labelElement);

        // the following assertion fails, even though it passed before - which is due to the assertEqualXMLStructure() has modified the $labelElement
        $this->assertEquals(1, $xpath->evaluate('count(//label[text() = "text content"])'));
    }
}
