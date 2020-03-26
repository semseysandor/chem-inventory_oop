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
final class StringStartsWithTest extends ConstraintTestCase
{
    public function testConstraintStringStartsWithCorrectValueAndReturnResult(): void
    {
        $constraint = new StringStartsWith('prefix');

        $this->assertTrue($constraint->evaluate('prefixfoo', '', true));
    }

    public function testConstraintStringStartsWithNotCorrectValueAndReturnResult(): void
    {
        $constraint = new StringStartsWith('prefix');

        $this->assertFalse($constraint->evaluate('error', '', true));
    }

    public function testConstraintStringStartsWithCorrectNumericValueAndReturnResult(): void
    {
        $constraint = new StringStartsWith('0E1');

        $this->assertTrue($constraint->evaluate('0E1zzz', '', true));
    }

    public function testConstraintStringStartsWithCorrectSingleZeroAndReturnResult(): void
    {
        $constraint = new StringStartsWith('0');

        $this->assertTrue($constraint->evaluate('0ABC', '', true));
    }

    public function testConstraintStringStartsWithNotCorrectNumericValueAndReturnResult(): void
    {
        $constraint = new StringStartsWith('0E1');

        $this->assertFalse($constraint->evaluate('0E2zzz', '', true));
    }

    public function testConstraintStringStartsWithToStringMethod(): void
    {
        $constraint = new StringStartsWith('prefix');

        $this->assertEquals('starts with "prefix"', $constraint->toString());
    }

    public function testConstraintStringStartsWitCountMethod(): void
    {
        $constraint = new StringStartsWith('prefix');

        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringStartsWithNotCorrectValueAndExpectation(): void
    {
        $constraint = new StringStartsWith('prefix');

        try {
            $constraint->evaluate('error');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that 'error' starts with "prefix".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintStringStartsWithNotCorrectValueExceptionAndCustomMessage(): void
    {
        $constraint = new StringStartsWith('prefix');

        try {
            $constraint->evaluate('error', 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that 'error' starts with "prefix".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
