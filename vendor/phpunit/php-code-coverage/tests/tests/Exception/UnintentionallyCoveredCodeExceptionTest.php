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
namespace SebastianBergmann\CodeCoverage\tests\Exception;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\CodeCoverage\RuntimeException;
use SebastianBergmann\CodeCoverage\UnintentionallyCoveredCodeException;

final class UnintentionallyCoveredCodeExceptionTest extends TestCase
{
    public function testCanConstructWithEmptyArray(): void
    {
        $unintentionallyCoveredUnits = [];

        $exception = new UnintentionallyCoveredCodeException($unintentionallyCoveredUnits);

        $this->assertInstanceOf(RuntimeException::class, $exception);
        $this->assertSame($unintentionallyCoveredUnits, $exception->getUnintentionallyCoveredUnits());
        $this->assertSame('', $exception->getMessage());
    }

    public function testCanConstructWithNonEmptyArray(): void
    {
        $unintentionallyCoveredUnits = [
            'foo',
            'bar',
            'baz',
        ];

        $exception = new UnintentionallyCoveredCodeException($unintentionallyCoveredUnits);

        $this->assertInstanceOf(RuntimeException::class, $exception);
        $this->assertSame($unintentionallyCoveredUnits, $exception->getUnintentionallyCoveredUnits());

        $expected = <<<TXT
- foo
- bar
- baz

TXT;

        $this->assertSame($expected, $exception->getMessage());
    }
}
