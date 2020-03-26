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

use PharIo\Version\Version;
use PHPUnit\Framework\TestCase;

/**
 * @covers PharIo\Manifest\BundledComponent
 *
 * @uses \PharIo\Version\Version
 */
class BundledComponentTest extends TestCase {
    /**
     * @var BundledComponent
     */
    private $bundledComponent;

    protected function setUp() {
        $this->bundledComponent = new BundledComponent('phpunit/php-code-coverage', new Version('4.0.2'));
    }

    public function testCanBeCreated() {
        $this->assertInstanceOf(BundledComponent::class, $this->bundledComponent);
    }

    public function testNameCanBeRetrieved() {
        $this->assertEquals('phpunit/php-code-coverage', $this->bundledComponent->getName());
    }

    public function testVersionCanBeRetrieved() {
        $this->assertEquals('4.0.2', $this->bundledComponent->getVersion()->getVersionString());
    }
}
