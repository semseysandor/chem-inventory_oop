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

class TemplateMethodsTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        print __METHOD__ . "\n";
    }

    public static function tearDownAfterClass(): void
    {
        print __METHOD__ . "\n";
    }

    protected function setUp(): void
    {
        print __METHOD__ . "\n";
    }

    protected function tearDown(): void
    {
        print __METHOD__ . "\n";
    }

    public function testOne(): void
    {
        print __METHOD__ . "\n";
        $this->assertTrue(true);
    }

    public function testTwo(): void
    {
        print __METHOD__ . "\n";
        $this->assertTrue(false);
    }

    protected function assertPreConditions(): void
    {
        print __METHOD__ . "\n";
    }

    protected function assertPostConditions(): void
    {
        print __METHOD__ . "\n";
    }

    protected function onNotSuccessfulTest(Throwable $t): void
    {
        print __METHOD__ . "\n";

        throw $t;
    }
}
