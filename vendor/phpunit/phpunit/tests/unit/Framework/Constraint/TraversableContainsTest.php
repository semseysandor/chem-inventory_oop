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
final class TraversableContainsTest extends ConstraintTestCase
{
    public function testConstraintTraversableCheckForNonObjectIdentityForDefaultCase(): void
    {
        $constraint = new TraversableContains('foo', true, true);

        $this->assertTrue($constraint->evaluate(['foo'], '', true));
    }

    public function testConstraintTraversableCheckForObjectIdentityForDefaultCase(): void
    {
        $constraint = new TraversableContains('foo');

        $this->assertTrue($constraint->evaluate([0], '', true));
        $this->assertTrue($constraint->evaluate([true], '', true));
    }

    public function testConstraintTraversableCheckForObjectIdentityForPrimitiveType(): void
    {
        $constraint = new TraversableContains('foo', true, true);

        $this->assertFalse($constraint->evaluate([0], '', true));
        $this->assertFalse($constraint->evaluate([true], '', true));
    }

    public function testConstraintTraversableWithRightValue(): void
    {
        $constraint = new TraversableContains('foo');

        $this->assertTrue($constraint->evaluate(['foo'], '', true));
    }

    public function testConstraintTraversableWithFailValue(): void
    {
        $constraint = new TraversableContains('foo');

        $this->assertFalse($constraint->evaluate(['bar'], '', true));
    }

    public function testConstraintTraversableCountMethods(): void
    {
        $constraint = new TraversableContains('foo');

        $this->assertCount(1, $constraint);
    }

    public function testConstraintTraversableEvaluateMethodWithFailExample(): void
    {
        $constraint = new TraversableContains('foo');

        try {
            $constraint->evaluate(['bar']);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that an array contains 'foo'.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }
        $this->fail();
    }

    public function testConstraintTraversableEvaluateMethodWithFailExample2(): void
    {
        $constraint = new TraversableContains('foo' . "\n");

        try {
            $constraint->evaluate(['bar']);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that an array contains "foo\n".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }
        $this->fail();
    }

    public function testConstraintTraversableEvaluateMethodWithFailExampleWithCustomMessage(): void
    {
        $constraint = new TraversableContains('foo');

        try {
            $constraint->evaluate(['bar'], 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that an array contains 'foo'.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintTraversableToStringMethodsWithStdClass(): void
    {
        $object     = new \stdClass;
        $constraint = new TraversableContains($object);
        $this->assertStringMatchesFormat('contains stdClass Object &%s ()', $constraint->toString());
    }

    public function testConstraintTraversableToStringMethods(): void
    {
        $constraint = new TraversableContains('foo');

        $this->assertEquals("contains 'foo'", $constraint->toString());
    }

    public function testConstraintTraversableToStringMethodsWithSplObjectStorage(): void
    {
        $object     = new \stdClass;
        $constraint = new TraversableContains($object);

        $storage = new \SplObjectStorage;
        $this->assertFalse($constraint->evaluate($storage, '', true));

        $storage->attach($object);
        $this->assertTrue($constraint->evaluate($storage, '', true));
    }

    public function testConstraintTraversableStdClassForFailSplObjectStorage(): void
    {
        $object     = new \stdClass;
        $constraint = new TraversableContains($object);

        try {
            $constraint->evaluate(new \SplObjectStorage);
        } catch (ExpectationFailedException $e) {
            $this->assertStringMatchesFormat(
                <<<EOF
Failed asserting that a traversable contains stdClass Object &%x ().

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintTraversableStdClassForFailSplObjectStorageWithCustomMessage(): void
    {
        $object     = new \stdClass;
        $constraint = new TraversableContains($object);

        try {
            $constraint->evaluate(new \SplObjectStorage, 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertStringMatchesFormat(
                <<<EOF
custom message
Failed asserting that a traversable contains stdClass Object &%x ().

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
