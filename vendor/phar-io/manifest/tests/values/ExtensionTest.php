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

use PharIo\Version\AnyVersionConstraint;
use PharIo\Version\Version;
use PharIo\Version\VersionConstraint;
use PharIo\Version\VersionConstraintParser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PharIo\Manifest\Extension
 * @covers \PharIo\Manifest\Type
 *
 * @uses \PharIo\Version\VersionConstraint
 * @uses \PharIo\Manifest\ApplicationName
 */
class ExtensionTest extends TestCase {
    /**
     * @var Extension
     */
    private $type;

    /**
     * @var ApplicationName|\PHPUnit_Framework_MockObject_MockObject
     */
    private $name;

    protected function setUp() {
        $this->name = $this->createMock(ApplicationName::class);
        $this->type = Type::extension($this->name, new AnyVersionConstraint);
    }

    public function testCanBeCreated() {
        $this->assertInstanceOf(Extension::class, $this->type);
    }

    public function testIsNotApplication() {
        $this->assertFalse($this->type->isApplication());
    }

    public function testIsNotLibrary() {
        $this->assertFalse($this->type->isLibrary());
    }

    public function testIsExtension() {
        $this->assertTrue($this->type->isExtension());
    }

    public function testApplicationCanBeRetrieved()
    {
        $this->assertInstanceOf(ApplicationName::class, $this->type->getApplicationName());
    }

    public function testVersionConstraintCanBeRetrieved() {
        $this->assertInstanceOf(
            VersionConstraint::class,
            $this->type->getVersionConstraint()
        );
    }

    public function testApplicationCanBeQueried()
    {
        $this->name->method('isEqual')->willReturn(true);
        $this->assertTrue(
            $this->type->isExtensionFor($this->createMock(ApplicationName::class))
        );
    }

    public function testCompatibleWithReturnsTrueForMatchingVersionConstraintAndApplicaiton() {
        $app = new ApplicationName('foo/bar');
        $extension = Type::extension($app, (new VersionConstraintParser)->parse('^1.0'));
        $version = new Version('1.0.0');

        $this->assertTrue(
            $extension->isCompatibleWith($app, $version)
        );
    }

    public function testCompatibleWithReturnsFalseForNotMatchingVersionConstraint() {
        $app = new ApplicationName('foo/bar');
        $extension = Type::extension($app, (new VersionConstraintParser)->parse('^1.0'));
        $version = new Version('2.0.0');

        $this->assertFalse(
            $extension->isCompatibleWith($app, $version)
        );
    }

    public function testCompatibleWithReturnsFalseForNotMatchingApplication() {
        $app1 = new ApplicationName('foo/bar');
        $app2 = new ApplicationName('foo/foo');
        $extension = Type::extension($app1, (new VersionConstraintParser)->parse('^1.0'));
        $version = new Version('1.0.0');

        $this->assertFalse(
            $extension->isCompatibleWith($app2, $version)
        );
    }

}
