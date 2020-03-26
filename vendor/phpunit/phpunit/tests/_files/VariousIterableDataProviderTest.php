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
class VariousIterableDataProviderTest extends AbstractVariousIterableDataProviderTest
{
    public static function asArrayStaticProvider()
    {
        return [
            ['A'],
            ['B'],
            ['C'],
        ];
    }

    public static function asIteratorStaticProvider()
    {
        yield ['D'];

        yield ['E'];

        yield ['F'];
    }

    public static function asTraversableStaticProvider()
    {
        return new WrapperIteratorAggregate([
            ['G'],
            ['H'],
            ['I'],
        ]);
    }

    /**
     * @dataProvider asArrayStaticProvider
     * @dataProvider asIteratorStaticProvider
     * @dataProvider asTraversableStaticProvider
     */
    public function testStatic(): void
    {
    }

    public function asArrayProvider()
    {
        return [
            ['S'],
            ['T'],
            ['U'],
        ];
    }

    public function asIteratorProvider()
    {
        yield ['V'];

        yield ['W'];

        yield ['X'];
    }

    public function asTraversableProvider()
    {
        return new WrapperIteratorAggregate([
            ['Y'],
            ['Z'],
            ['P'],
        ]);
    }

    /**
     * @dataProvider asArrayProvider
     * @dataProvider asIteratorProvider
     * @dataProvider asTraversableProvider
     */
    public function testNonStatic(): void
    {
    }

    /**
     * @dataProvider asArrayProviderInParent
     * @dataProvider asIteratorProviderInParent
     * @dataProvider asTraversableProviderInParent
     */
    public function testFromParent(): void
    {
    }
}
