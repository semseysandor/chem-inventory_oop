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

class DataproviderExecutionOrderTest extends TestCase
{
    public function testFirstTestThatAlwaysWorks(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @dataProvider dataproviderAdditions
     */
    public function testAddNumbersWithADataprovider(int $a, int $b, int $sum): void
    {
        $this->assertSame($sum, $a + $b);
    }

    public function testTestInTheMiddleThatAlwaysWorks(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @dataProvider dataproviderAdditions
     */
    public function testAddMoreNumbersWithADataprovider(int $a, int $b, int $sum): void
    {
        $this->assertSame($sum, $a + $b);
    }

    public function dataproviderAdditions()
    {
        return [
            '1+2=3' => [1, 2, 3],
            '2+1=3' => [2, 1, 3],
            '1+1=3' => [1, 1, 3],
        ];
    }
}
