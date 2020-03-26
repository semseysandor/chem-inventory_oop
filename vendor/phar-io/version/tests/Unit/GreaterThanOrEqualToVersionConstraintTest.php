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
 * @covers \PharIo\Version\GreaterThanOrEqualToVersionConstraint
 */
class GreaterThanOrEqualToVersionConstraintTest extends TestCase {
    public function versionProvider() {
        return [
            // compliant versions
            [new Version('1.0.2'), new Version('1.0.2'), true],
            [new Version('1.0.2'), new Version('1.0.3'), true],
            [new Version('1.0.2'), new Version('1.1.1'), true],
            [new Version('1.0.2'), new Version('2.0.0'), true],
            [new Version('1.0.2'), new Version('1.0.3'), true],
            // non-compliant versions
            [new Version('1.0.2'), new Version('1.0.1'), false],
            [new Version('1.9.8'), new Version('0.9.9'), false],
            [new Version('2.3.1'), new Version('2.2.3'), false],
            [new Version('3.0.2'), new Version('2.9.9'), false],
        ];
    }

    /**
     * @dataProvider versionProvider
     *
     * @param Version $constraintVersion
     * @param Version $version
     * @param bool $expectedResult
     */
    public function testReturnsTrueForCompliantVersions(Version $constraintVersion, Version $version, $expectedResult) {
        $constraint = new GreaterThanOrEqualToVersionConstraint('foo', $constraintVersion);

        $this->assertSame($expectedResult, $constraint->complies($version));
    }
}
