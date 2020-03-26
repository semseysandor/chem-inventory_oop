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

class DependencyFailureTest extends TestCase
{
    public function testOne(): void
    {
        $this->fail();
    }

    /**
     * @depends testOne
     */
    public function testTwo(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @depends !clone testTwo
     */
    public function testThree(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @depends clone testOne
     */
    public function testFour(): void
    {
        $this->assertTrue(true);
    }

    /**
     * This test has been added to check the printed warnings for the user
     * when a dependency simply doesn't exist.
     *
     * @depends doesNotExist
     *
     * @see https://github.com/sebastianbergmann/phpunit/issues/3517
     */
    public function testHandlesDependsAnnotationForNonexistentTests(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @depends
     */
    public function testHandlesDependsAnnotationWithNoMethodSpecified(): void
    {
        $this->assertTrue(true);
    }
}
