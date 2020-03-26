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
 * @covers \SebastianBergmann\Type\TypeName
 */
final class TypeNameTest extends TestCase
{
    public function testFromReflection(): void
    {
        $class    = new \ReflectionClass(TypeName::class);
        $typeName = TypeName::fromReflection($class);

        $this->assertTrue($typeName->isNamespaced());
        $this->assertEquals('SebastianBergmann\\Type', $typeName->getNamespaceName());
        $this->assertEquals(TypeName::class, $typeName->getQualifiedName());
        $this->assertEquals('TypeName', $typeName->getSimpleName());
    }

    public function testFromQualifiedName(): void
    {
        $typeName = TypeName::fromQualifiedName('PHPUnit\\Framework\\MockObject\\TypeName');

        $this->assertTrue($typeName->isNamespaced());
        $this->assertEquals('PHPUnit\\Framework\\MockObject', $typeName->getNamespaceName());
        $this->assertEquals('PHPUnit\\Framework\\MockObject\\TypeName', $typeName->getQualifiedName());
        $this->assertEquals('TypeName', $typeName->getSimpleName());
    }

    public function testFromQualifiedNameWithLeadingSeparator(): void
    {
        $typeName = TypeName::fromQualifiedName('\\Foo\\Bar');

        $this->assertTrue($typeName->isNamespaced());
        $this->assertEquals('Foo', $typeName->getNamespaceName());
        $this->assertEquals('Foo\\Bar', $typeName->getQualifiedName());
        $this->assertEquals('Bar', $typeName->getSimpleName());
    }

    public function testFromQualifiedNameWithoutNamespace(): void
    {
        $typeName = TypeName::fromQualifiedName('Bar');

        $this->assertFalse($typeName->isNamespaced());
        $this->assertNull($typeName->getNamespaceName());
        $this->assertEquals('Bar', $typeName->getQualifiedName());
        $this->assertEquals('Bar', $typeName->getSimpleName());
    }
}
