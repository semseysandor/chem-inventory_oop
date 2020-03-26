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
final class LogicalOrTest extends ConstraintTestCase
{
    public function testSetConstraintsDecoratesNonConstraintWithIsEqual(): void
    {
        $constraints = [
            new \stdClass,
        ];

        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        $this->assertTrue($constraint->evaluate(new \stdClass, '', true));
    }

    public function testCountReturnsCountOfComposedConstraints(): void
    {
        $counts = [
            3,
            5,
            8,
        ];

        $constraints = \array_map(function (int $count) {
            return \CountConstraint::fromCount($count);
        }, $counts);

        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        $expected = \array_sum($counts);

        $this->assertSame($expected, $constraint->count());
    }

    public function testToStringReturnsImplodedStringRepresentationOfComposedConstraintsGluedWithOr(): void
    {
        $names = [
            'is healthy',
            'is rich in amino acids',
            'is rich in unsaturated fats',
        ];

        $constraints = \array_map(function (string $name) {
            return \NamedConstraint::fromName($name);
        }, $names);

        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        $expected = \implode(' or ', $names);

        $this->assertSame($expected, $constraint->toString());
    }

    /**
     * @dataProvider providerFailingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateReturnsFalseIfAllOfTheComposedConstraintsEvaluateToFalse(array $constraints): void
    {
        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        $this->assertFalse($constraint->evaluate('whatever', '', true));
    }

    /**
     * @dataProvider providerSucceedingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateReturnsTrueIfAnyOfTheComposedConstraintsEvaluateToTrue(array $constraints): void
    {
        $constraint = LogicalOr::fromConstraints(...$constraints);

        $this->assertTrue($constraint->evaluate('whatever', '', true));
    }

    /**
     * @dataProvider providerFailingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateThrowsExceptionIfAllOfTheComposedConstraintsEvaluateToFalse(array $constraints): void
    {
        $other = 'whatever';

        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        try {
            $constraint->evaluate($other);
        } catch (ExpectationFailedException $exception) {
            $toString = $this->stringify($constraints);

            $expectedDescription = <<<EOF
Failed asserting that '$other' $toString.

EOF;

            $this->assertEquals($expectedDescription, TestFailure::exceptionToString($exception));

            return;
        }

        $this->fail();
    }

    /**
     * @dataProvider providerFailingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateThrowsExceptionWithCustomMessageIfAllOfTheComposedConstraintsEvaluateToFalse(array $constraints): void
    {
        $other             = 'whatever';
        $customDescription = 'Not very happy about the results at this point in time, I have to admit!';

        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        try {
            $constraint->evaluate(
                $other,
                $customDescription
            );
        } catch (ExpectationFailedException $exception) {
            $toString = $this->stringify($constraints);

            $expectedDescription = <<<EOF
$customDescription
Failed asserting that '$other' $toString.

EOF;

            $this->assertEquals($expectedDescription, TestFailure::exceptionToString($exception));

            return;
        }

        $this->fail();
    }

    /**
     * @dataProvider providerSucceedingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateReturnsNothingIfAnyOfTheComposedConstraintsEvaluateToTrue(array $constraints): void
    {
        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        $this->assertNull($constraint->evaluate('whatever'));
    }

    public function providerFailingConstraints(): \Generator
    {
        $values = [
            'single' => [
                new \FalsyConstraint,
                new \FalsyConstraint,
                new \FalsyConstraint,
            ],
            'multiple' => [
                new \FalsyConstraint,
                new \FalsyConstraint,
                new \FalsyConstraint,
            ],
        ];

        foreach ($values as $key => $constraints) {
            yield $key => [
                $constraints,
            ];
        }
    }

    public function providerSucceedingConstraints(): \Generator
    {
        $values = [
            'single' => [
                new \TruthyConstraint,
            ],
            'multiple' => [
                new \FalsyConstraint,
                new \TruthyConstraint,
                new \FalsyConstraint,
            ],
        ];

        foreach ($values as $key => $constraints) {
            yield $key => [
                $constraints,
            ];
        }
    }

    private function stringify(array $constraints): string
    {
        return \implode(
            ' or ',
            \array_map(function (Constraint $constraint) {
                return $constraint->toString();
            }, $constraints)
        );
    }
}
