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
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

/**
 * @small
 */
final class SameSizeTest extends ConstraintTestCase
{
    public function testConstraintSameSizeWithAnArray(): void
    {
        $constraint = new SameSize([1, 2, 3, 4, 5]);

        $this->assertTrue($constraint->evaluate([6, 7, 8, 9, 10], '', true));
        $this->assertFalse($constraint->evaluate([1, 2, 3, 4], '', true));
    }

    public function testConstraintSameSizeWithAnIteratorWhichDoesNotImplementCountable(): void
    {
        $constraint = new SameSize(new \TestIterator([1, 2, 3, 4, 5]));

        $this->assertTrue($constraint->evaluate(new \TestIterator([6, 7, 8, 9, 10]), '', true));
        $this->assertFalse($constraint->evaluate(new \TestIterator([1, 2, 3, 4]), '', true));
    }

    public function testConstraintSameSizeWithAnObjectImplementingCountable(): void
    {
        $constraint = new SameSize(new \ArrayObject([1, 2, 3, 4, 5]));

        $this->assertTrue($constraint->evaluate(new \ArrayObject([6, 7, 8, 9, 10]), '', true));
        $this->assertFalse($constraint->evaluate(new \ArrayObject([1, 2, 3, 4]), '', true));
    }

    public function testConstraintSameSizeFailing(): void
    {
        $constraint = new SameSize([1, 2, 3, 4, 5]);

        try {
            $constraint->evaluate([1, 2]);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that actual size 2 matches expected size 5.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
