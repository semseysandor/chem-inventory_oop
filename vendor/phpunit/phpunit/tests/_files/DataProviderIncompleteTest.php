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

class DataProviderIncompleteTest extends TestCase
{
    public static function providerMethod()
    {
        return [
            [0, 0, 0],
            [0, 1, 1],
        ];
    }

    /**
     * @dataProvider incompleteTestProviderMethod
     */
    public function testIncomplete($a, $b, $c): void
    {
        $this->assertTrue(true);
    }

    /**
     * @dataProvider providerMethod
     */
    public function testAdd($a, $b, $c): void
    {
        $this->assertEquals($c, $a + $b);
    }

    public function incompleteTestProviderMethod()
    {
        $this->markTestIncomplete('incomplete');

        return [
            [0, 0, 0],
            [0, 1, 1],
        ];
    }
}
