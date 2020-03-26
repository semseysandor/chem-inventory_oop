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

class DataProviderDebugTest extends TestCase
{
    public static function provider()
    {
        $obj2      = new \stdClass;
        $obj2->foo = 'bar';

        $obj3 = (object) [1, 2, "Test\r\n", 4, 5, 6, 7, 8];

        $obj = new \stdClass;
        //@codingStandardsIgnoreStart
        $obj->null = null;
        //@codingStandardsIgnoreEnd
        $obj->boolean     = true;
        $obj->integer     = 1;
        $obj->double      = 1.2;
        $obj->string      = '1';
        $obj->text        = "this\nis\na\nvery\nvery\nvery\nvery\nvery\nvery\rlong\n\rtext";
        $obj->object      = $obj2;
        $obj->objectagain = $obj2;
        $obj->array       = ['foo' => 'bar'];
        $obj->self        = $obj;

        $storage = new \SplObjectStorage;
        $storage->attach($obj2);
        $storage->foo = $obj;

        return [
            [null, true, 1, 1.0],
            [1.2, \fopen('php://memory', 'r'), '1'],
            [[[1, 2, 3], [3, 4, 5]]],
            // \n\r and \r is converted to \n
            ["this\nis\na\nvery\nvery\nvery\nvery\nvery\nvery\rlong\n\rtext"],
            [new \stdClass, $obj, [], $storage, $obj3],
            [\chr(0) . \chr(1) . \chr(2) . \chr(3) . \chr(4) . \chr(5), \implode('', \array_map('chr', \range(0x0e, 0x1f)))],
            [\chr(0x00) . \chr(0x09)],
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testProvider(): void
    {
        $this->assertTrue(true);
    }
}
