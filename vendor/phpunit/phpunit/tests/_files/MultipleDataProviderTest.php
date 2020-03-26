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

class MultipleDataProviderTest extends TestCase
{
    public static function providerA()
    {
        return [
            ['ok', null, null],
            ['ok', null, null],
            ['ok', null, null],
        ];
    }

    public static function providerB()
    {
        return [
            [null, 'ok', null],
            [null, 'ok', null],
            [null, 'ok', null],
        ];
    }

    public static function providerC()
    {
        return [
            [null, null, 'ok'],
            [null, null, 'ok'],
            [null, null, 'ok'],
        ];
    }

    public static function providerD()
    {
        yield ['ok', null, null];

        yield ['ok', null, null];

        yield ['ok', null, null];
    }

    public static function providerE()
    {
        yield [null, 'ok', null];

        yield [null, 'ok', null];

        yield [null, 'ok', null];
    }

    public static function providerF()
    {
        $object = new ArrayObject(
            [
                [null, null, 'ok'],
                [null, null, 'ok'],
                [null, null, 'ok'],
            ]
        );

        return $object->getIterator();
    }

    /**
     * @dataProvider providerA
     * @dataProvider providerB
     * @dataProvider providerC
     */
    public function testOne(): void
    {
    }

    /**
     * @dataProvider providerD
     * @dataProvider providerE
     * @dataProvider providerF
     */
    public function testTwo(): void
    {
    }
}
