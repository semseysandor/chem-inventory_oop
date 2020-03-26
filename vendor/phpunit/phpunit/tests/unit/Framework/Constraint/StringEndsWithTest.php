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
final class StringEndsWithTest extends ConstraintTestCase
{
    public function testConstraintStringEndsWithCorrectValueAndReturnResult(): void
    {
        $constraint = new StringEndsWith('suffix');

        $this->assertTrue($constraint->evaluate('foosuffix', '', true));
    }

    public function testConstraintStringEndsWithNotCorrectValueAndReturnResult(): void
    {
        $constraint = new StringEndsWith('suffix');

        $this->assertFalse($constraint->evaluate('suffixerror', '', true));
    }

    public function testConstraintStringEndsWithCorrectNumericValueAndReturnResult(): void
    {
        $constraint = new StringEndsWith('0E1');

        $this->assertTrue($constraint->evaluate('zzz0E1', '', true));
    }

    public function testConstraintStringEndsWithNotCorrectNumericValueAndReturnResult(): void
    {
        $constraint = new StringEndsWith('0E1');

        $this->assertFalse($constraint->evaluate('zzz0E2', '', true));
    }

    public function testConstraintStringEndsWithToStringMethod(): void
    {
        $constraint = new StringEndsWith('suffix');

        $this->assertEquals('ends with "suffix"', $constraint->toString());
    }

    public function testConstraintStringEndsWithCountMethod(): void
    {
        $constraint = new StringEndsWith('suffix');

        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringEndsWithNotCorrectValueAndExpectation(): void
    {
        $constraint = new StringEndsWith('suffix');

        try {
            $constraint->evaluate('error');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that 'error' ends with "suffix".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintStringEndsWithNotCorrectValueExceptionAndCustomMessage(): void
    {
        $constraint = new StringEndsWith('suffix');

        try {
            $constraint->evaluate('error', 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that 'error' ends with "suffix".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
