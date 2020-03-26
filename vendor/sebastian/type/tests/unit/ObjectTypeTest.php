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
use SebastianBergmann\Type\TestFixture\ChildClass;
use SebastianBergmann\Type\TestFixture\ParentClass;

/**
 * @covers \SebastianBergmann\Type\ObjectType
 *
 * @uses \SebastianBergmann\Type\TypeName
 * @uses \SebastianBergmann\Type\Type
 * @uses \SebastianBergmann\Type\SimpleType
 */
final class ObjectTypeTest extends TestCase
{
    /**
     * @var ObjectType
     */
    private $childClass;

    /**
     * @var ObjectType
     */
    private $parentClass;

    protected function setUp(): void
    {
        $this->childClass = new ObjectType(
            TypeName::fromQualifiedName(ChildClass::class),
            false
        );

        $this->parentClass = new ObjectType(
            TypeName::fromQualifiedName(ParentClass::class),
            false
        );
    }

    public function testParentIsNotAssignableToChild(): void
    {
        $this->assertFalse($this->childClass->isAssignable($this->parentClass));
    }

    public function testChildIsAssignableToParent(): void
    {
        $this->assertTrue($this->parentClass->isAssignable($this->childClass));
    }

    public function testClassIsAssignableToSelf(): void
    {
        $this->assertTrue($this->parentClass->isAssignable($this->parentClass));
    }

    public function testSimpleTypeIsNotAssignableToClass(): void
    {
        $this->assertFalse($this->parentClass->isAssignable(new SimpleType('int', false)));
    }

    public function testClassFromOneNamespaceIsNotAssignableToClassInOtherNamespace(): void
    {
        $classFromNamespaceA = new ObjectType(
            TypeName::fromQualifiedName(\someNamespaceA\NamespacedClass::class),
            false
        );

        $classFromNamespaceB = new ObjectType(
            TypeName::fromQualifiedName(\someNamespaceB\NamespacedClass::class),
            false
        );
        $this->assertFalse($classFromNamespaceA->isAssignable($classFromNamespaceB));
    }

    public function testClassIsAssignableToSelfCaseInsensitively(): void
    {
        $classLowercased = new ObjectType(
            TypeName::fromQualifiedName(\strtolower(ParentClass::class)),
            false
        );

        $this->assertTrue($this->parentClass->isAssignable($classLowercased));
    }

    public function testNullIsAssignableToNullableType(): void
    {
        $someClass = new ObjectType(
            TypeName::fromQualifiedName(ParentClass::class),
            true
        );
        $this->assertTrue($someClass->isAssignable(Type::fromValue(null, true)));
    }

    public function testNullIsNotAssignableToNotNullableType(): void
    {
        $someClass = new ObjectType(
            TypeName::fromQualifiedName(ParentClass::class),
            false
        );

        $this->assertFalse($someClass->isAssignable(Type::fromValue(null, true)));
    }

    public function testPreservesNullNotAllowed(): void
    {
        $someClass = new ObjectType(
            TypeName::fromQualifiedName(ParentClass::class),
            false
        );

        $this->assertFalse($someClass->allowsNull());
    }

    public function testPreservesNullAllowed(): void
    {
        $someClass = new ObjectType(
            TypeName::fromQualifiedName(ParentClass::class),
            true
        );

        $this->assertTrue($someClass->allowsNull());
    }

    public function testCanGenerateReturnTypeDeclaration(): void
    {
        $this->assertEquals(': SebastianBergmann\Type\TestFixture\ParentClass', $this->parentClass->getReturnTypeDeclaration());
    }

    public function testHasClassName(): void
    {
        $this->assertEquals('SebastianBergmann\Type\TestFixture\ParentClass', $this->parentClass->className()->getQualifiedName());
    }
}
