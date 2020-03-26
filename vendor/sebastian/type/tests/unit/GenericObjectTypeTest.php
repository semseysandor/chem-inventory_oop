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

/**
 * @covers \SebastianBergmann\Type\GenericObjectType
 *
 * @uses \SebastianBergmann\Type\Type
 * @uses \SebastianBergmann\Type\ObjectType
 * @uses \SebastianBergmann\Type\SimpleType
 * @uses \SebastianBergmann\Type\TypeName
 */
final class GenericObjectTypeTest extends TestCase
{
    /**
     * @var GenericObjectType
     */
    private $type;

    protected function setUp(): void
    {
        $this->type = new GenericObjectType(false);
    }

    public function testMayDisallowNull(): void
    {
        $this->assertFalse($this->type->allowsNull());
    }

    public function testCanGenerateReturnTypeDeclaration(): void
    {
        $this->assertEquals(': object', $this->type->getReturnTypeDeclaration());
    }

    public function testMayAllowNull(): void
    {
        $type = new GenericObjectType(true);

        $this->assertTrue($type->allowsNull());
    }

    public function testCanGenerateNullableReturnTypeDeclaration(): void
    {
        $type = new GenericObjectType(true);

        $this->assertEquals(': ?object', $type->getReturnTypeDeclaration());
    }

    public function testObjectCanBeAssignedToGenericObject(): void
    {
        $this->assertTrue(
            $this->type->isAssignable(
                new ObjectType(TypeName::fromQualifiedName(\stdClass::class), false)
            )
        );
    }

    public function testNullCanBeAssignedToNullableGenericObject(): void
    {
        $type = new GenericObjectType(true);

        $this->assertTrue(
            $type->isAssignable(
                new NullType
            )
        );
    }

    public function testNonObjectCannotBeAssignedToGenericObject(): void
    {
        $this->assertFalse(
            $this->type->isAssignable(
                new SimpleType('bool', false)
            )
        );
    }
}
