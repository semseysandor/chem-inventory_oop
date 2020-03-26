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
namespace Framework\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\LogicalXor;
use PHPUnit\Framework\TestCase;

/**
 * @small
 */
final class LogicalXorTest extends TestCase
{
    public function testFromConstraintsReturnsConstraint(): void
    {
        $other = 'Foo';
        $count = 5;

        $constraints = \array_map(function () use ($other) {
            static $count = 0;

            $constraint = $this->getMockBuilder(Constraint::class)->getMock();

            $constraint
                ->expects($this->once())
                ->method('evaluate')
                ->with($this->identicalTo($other))
                ->willReturn($count % 2 === 1);

            ++$count;

            return $constraint;
        }, \array_fill(0, $count, null));

        $constraint = LogicalXor::fromConstraints(...$constraints);

        $this->assertInstanceOf(LogicalXor::class, $constraint);
        $this->assertTrue($constraint->evaluate($other, '', true));
    }

    public function testSetConstraintsWithNonConstraintsObjectArrayIsTreatedAsIsEqual(): void
    {
        $constraint = new LogicalXor;

        $constraint->setConstraints(['cuckoo']);

        $this->assertSame('is equal to \'cuckoo\'', $constraint->toString());
    }
}
