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
namespace PHPUnit\Util;

use PHPUnit\Framework\TestCase;

/**
 * @small
 */
final class RegularExpressionTest extends TestCase
{
    public function validRegexpProvider(): array
    {
        return [
            ['#valid regexp#', 'valid regexp', 1],
            [';val.*xp;', 'valid regexp', 1],
            ['/val.*xp/i', 'VALID REGEXP', 1],
            ['/a val.*p/', 'valid regexp', 0],
        ];
    }

    public function invalidRegexpProvider(): array
    {
        return [
            ['valid regexp', 'valid regexp'],
            [';val.*xp', 'valid regexp'],
            ['val.*xp/i', 'VALID REGEXP'],
        ];
    }

    /**
     * @testdox Valid regex $pattern on $subject returns $return
     * @dataProvider validRegexpProvider
     *
     * @throws \Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testValidRegex($pattern, $subject, $return): void
    {
        $this->assertEquals($return, RegularExpression::safeMatch($pattern, $subject));
    }

    /**
     * @testdox Invalid regex $pattern on $subject
     * @dataProvider invalidRegexpProvider
     *
     * @throws \Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testInvalidRegex($pattern, $subject): void
    {
        $this->assertFalse(RegularExpression::safeMatch($pattern, $subject));
    }
}
