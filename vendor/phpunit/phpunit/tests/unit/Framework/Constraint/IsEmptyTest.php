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
final class IsEmptyTest extends ConstraintTestCase
{
    public function testConstraintIsEmpty(): void
    {
        $constraint = new IsEmpty;

        $this->assertFalse($constraint->evaluate(['foo'], '', true));
        $this->assertTrue($constraint->evaluate([], '', true));
        $this->assertFalse($constraint->evaluate(new \ArrayObject(['foo']), '', true));
        $this->assertTrue($constraint->evaluate(new \ArrayObject([]), '', true));
        $this->assertEquals('is empty', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate(['foo']);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that an array is empty.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintIsEmpty2(): void
    {
        $constraint = new IsEmpty;

        try {
            $constraint->evaluate(['foo'], 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message\nFailed asserting that an array is empty.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    /**
     * @ticket https://github.com/sebastianbergmann/phpunit/issues/3743
     */
    public function test_EmptyIterator_is_handled_correctly(): void
    {
        $constraint = new IsEmpty;

        $this->assertTrue($constraint->evaluate(new \EmptyIterator, '', true));
    }
}
