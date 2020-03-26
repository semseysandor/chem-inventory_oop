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

namespace PharIo\Version;

use PHPUnit\Framework\TestCase;

/**
 * @covers \PharIo\Version\OrVersionConstraintGroup
 */
class OrVersionConstraintGroupTest extends TestCase {
    public function testReturnsTrueIfOneConstraintReturnsFalse() {
        $firstConstraint = $this->createMock(VersionConstraint::class);
        $secondConstraint = $this->createMock(VersionConstraint::class);

        $firstConstraint->expects($this->once())
            ->method('complies')
            ->will($this->returnValue(false));

        $secondConstraint->expects($this->once())
            ->method('complies')
            ->will($this->returnValue(true));

        $group = new OrVersionConstraintGroup('foo', [$firstConstraint, $secondConstraint]);

        $this->assertTrue($group->complies(new Version('1.0.0')));
    }

    public function testReturnsTrueIfAllConstraintsReturnsTrue() {
        $firstConstraint = $this->createMock(VersionConstraint::class);
        $secondConstraint = $this->createMock(VersionConstraint::class);

        $firstConstraint->expects($this->once())
            ->method('complies')
            ->will($this->returnValue(true));

        $group = new OrVersionConstraintGroup('foo', [$firstConstraint, $secondConstraint]);

        $this->assertTrue($group->complies(new Version('1.0.0')));
    }

    public function testReturnsFalseIfAllConstraintsReturnsFalse() {
        $firstConstraint = $this->createMock(VersionConstraint::class);
        $secondConstraint = $this->createMock(VersionConstraint::class);

        $firstConstraint->expects($this->once())
            ->method('complies')
            ->will($this->returnValue(false));

        $secondConstraint->expects($this->once())
            ->method('complies')
            ->will($this->returnValue(false));

        $group = new OrVersionConstraintGroup('foo', [$firstConstraint, $secondConstraint]);

        $this->assertFalse($group->complies(new Version('1.0.0')));
    }
}
