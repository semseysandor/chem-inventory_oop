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
namespace SebastianBergmann\Type;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Type\TestFixture\Iterator;

/**
 * @covers \SebastianBergmann\Type\IterableType
 *
 * @uses \SebastianBergmann\Type\Type
 * @uses \SebastianBergmann\Type\TypeName
 * @uses \SebastianBergmann\Type\ObjectType
 * @uses \SebastianBergmann\Type\SimpleType
 */
final class IterableTypeTest extends TestCase
{
    /**
     * @var IterableType
     */
    private $type;

    protected function setUp(): void
    {
        $this->type = new IterableType(false);
    }

    public function testMayDisallowNull(): void
    {
        $this->assertFalse($this->type->allowsNull());
    }

    public function testCanGenerateReturnTypeDeclaration(): void
    {
        $this->assertEquals(': iterable', $this->type->getReturnTypeDeclaration());
    }

    public function testMayAllowNull(): void
    {
        $type = new IterableType(true);

        $this->assertTrue($type->allowsNull());
    }

    public function testCanGenerateNullableReturnTypeDeclaration(): void
    {
        $type = new IterableType(true);

        $this->assertEquals(': ?iterable', $type->getReturnTypeDeclaration());
    }

    public function testNullCanBeAssignedToNullableIterable(): void
    {
        $type = new IterableType(true);

        $this->assertTrue($type->isAssignable(new NullType));
    }

    public function testIterableCanBeAssignedToIterable(): void
    {
        $this->assertTrue($this->type->isAssignable(new IterableType(false)));
    }

    public function testArrayCanBeAssignedToIterable(): void
    {
        $this->assertTrue(
            $this->type->isAssignable(
                Type::fromValue([], false)
            )
        );
    }

    public function testIteratorCanBeAssignedToIterable(): void
    {
        $this->assertTrue(
            $this->type->isAssignable(
                Type::fromValue(new Iterator, false)
            )
        );
    }

    public function testSomethingThatIsNotIterableCannotBeAssignedToIterable(): void
    {
        $this->assertFalse(
            $this->type->isAssignable(
                Type::fromValue(null, false)
            )
        );
    }
}
