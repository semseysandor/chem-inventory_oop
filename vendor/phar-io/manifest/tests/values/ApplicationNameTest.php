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

use PHPUnit\Framework\TestCase;

class ApplicationNameTest extends TestCase {

    public function testCanBeCreatedWithValidName() {
        $this->assertInstanceOf(
            ApplicationName::class,
            new ApplicationName('foo/bar')
        );
    }

    public function testUsingInvalidFormatForNameThrowsException() {
        $this->expectException(InvalidApplicationNameException::class);
        $this->expectExceptionCode(InvalidApplicationNameException::InvalidFormat);
        new ApplicationName('foo');
    }

    public function testUsingWrongTypeForNameThrowsException() {
        $this->expectException(InvalidApplicationNameException::class);
        $this->expectExceptionCode(InvalidApplicationNameException::NotAString);
        new ApplicationName(123);
    }

    public function testReturnsTrueForEqualNamesWhenCompared() {
        $app = new ApplicationName('foo/bar');
        $this->assertTrue(
            $app->isEqual($app)
        );
    }

    public function testReturnsFalseForNonEqualNamesWhenCompared() {
        $app1 = new ApplicationName('foo/bar');
        $app2 = new ApplicationName('foo/foo');
        $this->assertFalse(
            $app1->isEqual($app2)
        );
    }

    public function testCanBeConvertedToString() {
        $this->assertEquals(
            'foo/bar',
            new ApplicationName('foo/bar')
        );
    }
}
