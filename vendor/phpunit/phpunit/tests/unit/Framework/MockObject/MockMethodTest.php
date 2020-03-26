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
namespace PHPUnit\Framework\MockObject;

use PHPUnit\Framework\TestCase;
use PHPUnit\TestFixture\MockObject\ClassWithoutParentButParentReturnType;
use SebastianBergmann\Type\UnknownType;

/**
 * @small
 */
final class MockMethodTest extends TestCase
{
    public function testGetNameReturnsMethodName(): void
    {
        $method = new MockMethod(
            'ClassName',
            'methodName',
            false,
            '',
            '',
            '',
            new UnknownType,
            '',
            false,
            false,
            null,
            false
        );
        $this->assertEquals('methodName', $method->getName());
    }

    /**
     * @requires PHP < 7.4
     */
    public function testFailWhenReturnTypeIsParentButThereIsNoParentClass(): void
    {
        $class = new \ReflectionClass(ClassWithoutParentButParentReturnType::class);

        $this->expectException(\RuntimeException::class);
        MockMethod::fromReflection($class->getMethod('foo'), false, false);
    }
}
