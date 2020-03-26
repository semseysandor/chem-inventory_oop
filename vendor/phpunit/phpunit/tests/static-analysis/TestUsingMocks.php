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
namespace PHPUnit\StaticAnalysis;

use PHPUnit\Framework\TestCase;

class HelloWorldClass
{
    public function sayHello(): string
    {
        return 'hello world!';
    }
}

/**
 * @small
 */
final class TestUsingMocks extends TestCase
{
    public function testWillSayHelloThroughCreateMock(): void
    {
        $mock = $this->createMock(HelloWorldClass::class);

        $mock
            ->method('sayHello')
            ->willReturn('hello mock!');

        self::assertSame('hello mock!', $mock->sayHello());
    }

    public function testWillSayHelloThroughCreateStub(): void
    {
        $mock = $this->createStub(HelloWorldClass::class);

        $mock
            ->method('sayHello')
            ->willReturn('hello stub!');

        self::assertSame('hello stub!', $mock->sayHello());
    }

    public function testWillSayHelloThroughCreateConfiguredMock(): void
    {
        $mock = $this->createConfiguredMock(HelloWorldClass::class, []);

        $mock
            ->method('sayHello')
            ->willReturn('hello mock!');

        self::assertSame('hello mock!', $mock->sayHello());
    }

    public function testWillSayHelloThroughCreatePartialMock(): void
    {
        $mock = $this->createPartialMock(HelloWorldClass::class, []);

        $mock
            ->method('sayHello')
            ->willReturn('hello mock!');

        self::assertSame('hello mock!', $mock->sayHello());
    }

    public function testWillSayHelloThroughCreateTestProxy(): void
    {
        $mock = $this->createTestProxy(HelloWorldClass::class, []);

        $mock
            ->method('sayHello')
            ->willReturn('hello mock!');

        self::assertSame('hello mock!', $mock->sayHello());
    }

    public function testWillSayHelloThroughGetMockBuilder(): void
    {
        $mock = $this
            ->getMockBuilder(HelloWorldClass::class)
            ->getMock();

        $mock
            ->method('sayHello')
            ->willReturn('hello mock!');

        self::assertSame('hello mock!', $mock->sayHello());
    }
}
