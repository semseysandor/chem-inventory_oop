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

use PharIo\Version\ExactVersionConstraint;
use PHPUnit\Framework\TestCase;

/**
 * @covers PharIo\Manifest\PhpVersionRequirement
 *
 * @uses \PharIo\Version\VersionConstraint
 */
class PhpVersionRequirementTest extends TestCase {
    /**
     * @var PhpVersionRequirement
     */
    private $requirement;

    protected function setUp() {
        $this->requirement = new PhpVersionRequirement(new ExactVersionConstraint('7.1.0'));
    }

    public function testCanBeCreated() {
        $this->assertInstanceOf(PhpVersionRequirement::class, $this->requirement);
    }

    public function testVersionConstraintCanBeRetrieved() {
        $this->assertEquals('7.1.0', $this->requirement->getVersionConstraint()->asString());
    }
}
