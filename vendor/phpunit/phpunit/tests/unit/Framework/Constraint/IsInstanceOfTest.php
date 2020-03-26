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
final class IsInstanceOfTest extends ConstraintTestCase
{
    public function testConstraintInstanceOf(): void
    {
        $constraint = new IsInstanceOf(\stdClass::class);

        self::assertTrue($constraint->evaluate(new \stdClass, '', true));
    }

    public function testConstraintFailsOnString(): void
    {
        $constraint = new IsInstanceOf(\stdClass::class);

        try {
            $constraint->evaluate('stdClass');
        } catch (ExpectationFailedException $e) {
            self::assertSame(
                <<<EOT
Failed asserting that 'stdClass' is an instance of class "stdClass".

EOT
                ,
                TestFailure::exceptionToString($e)
            );
        }
    }

    public function testCronstraintsThrowsReflectionException(): void
    {
        $this->throwException(new \ReflectionException);

        $constraint = new IsInstanceOf(NotExistingClass::class);

        self::assertSame(
            'is instance of class "PHPUnit\Framework\Constraint\NotExistingClass"',
            $constraint->toString()
        );
    }
}
