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
 * @covers \PharIo\Version\SpecificMajorAndMinorVersionConstraint
 */
class SpecificMajorAndMinorVersionConstraintTest extends TestCase {
    public function versionProvider() {
        return [
            // compliant versions
            [1, 0, new Version('1.0.2'), true],
            [1, 0, new Version('1.0.3'), true],
            [1, 1, new Version('1.1.1'), true],
            // non-compliant versions
            [2, 9, new Version('0.9.9'), false],
            [3, 2, new Version('2.2.3'), false],
            [2, 8, new Version('2.9.9'), false],
        ];
    }

    /**
     * @dataProvider versionProvider
     *
     * @param int $major
     * @param int $minor
     * @param Version $version
     * @param bool $expectedResult
     */
    public function testReturnsTrueForCompliantVersions($major, $minor, Version $version, $expectedResult) {
        $constraint = new SpecificMajorAndMinorVersionConstraint('foo', $major, $minor);

        $this->assertSame($expectedResult, $constraint->complies($version));
    }
}
