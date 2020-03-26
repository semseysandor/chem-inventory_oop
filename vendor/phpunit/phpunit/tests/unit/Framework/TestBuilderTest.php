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
namespace PHPUnit\Framework;

use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \PHPUnit\Framework\TestBuilder
 */
final class TestBuilderTest extends TestCase
{
    public function testCreateTestForConstructorlessTestClass(): void
    {
        $reflector = $this->getMockBuilder(\ReflectionClass::class)
                          ->setConstructorArgs([$this])
                          ->getMock();

        \assert($reflector instanceof MockObject);
        \assert($reflector instanceof \ReflectionClass);

        $reflector->expects($this->once())
                  ->method('getConstructor')
                  ->willReturn(null);

        $reflector->expects($this->once())
                  ->method('isInstantiable')
                  ->willReturn(true);

        $reflector->expects($this->once())
                  ->method('getName')
                  ->willReturn(__CLASS__);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('No valid test provided.');

        (new TestBuilder)->build($reflector, 'TestForConstructorlessTestClass');
    }

    public function testCreateTestForNotInstantiableTestClass(): void
    {
        $reflector = $this->getMockBuilder(\ReflectionClass::class)
            ->setConstructorArgs([$this])
            ->getMock();

        \assert($reflector instanceof MockObject);
        \assert($reflector instanceof \ReflectionClass);

        $reflector->expects($this->once())
            ->method('isInstantiable')
            ->willReturn(false);

        $reflector->expects($this->once())
            ->method('getName')
            ->willReturn('foo');

        $test = (new TestBuilder)->build($reflector, 'TestForNonInstantiableTestClass');
        $this->assertInstanceOf(WarningTestCase::class, $test);
        /* @var WarningTestCase $test */
        $this->assertSame('Cannot instantiate class "foo".', $test->getMessage());
    }

    public function testCreateTestForTestClassWithModifiedConstructor(): void
    {
        $test = (new TestBuilder)->build(new \ReflectionClass(\ModifiedConstructorTestCase::class), 'testCase');
        $this->assertInstanceOf(\ModifiedConstructorTestCase::class, $test);
    }

    public function testCreateWithEmptyData(): void
    {
        $test = (new TestBuilder)->build(new \ReflectionClass(\EmptyDataProviderTest::class), 'testCase');
        $this->assertInstanceOf(DataProviderTestSuite::class, $test);
        /* @var DataProviderTestSuite $test */
        $this->assertInstanceOf(SkippedTestCase::class, $test->getGroupDetails()['default'][0]);
    }

    /**
     * @dataProvider provideWithAnnotations
     */
    public function testWithAnnotations(string $methodName): void
    {
        $test = (new TestBuilder)->build(new \ReflectionClass(\TestWithAnnotations::class), $methodName);
        $this->assertInstanceOf(\TestWithAnnotations::class, $test);
    }

    public function provideWithAnnotations(): array
    {
        return [
            ['testThatInteractsWithGlobalVariables'],
            ['testThatInteractsWithStaticAttributes'],
            ['testInSeparateProcess'],
        ];
    }

    /**
     * @dataProvider provideWithAnnotationsAndDataProvider
     */
    public function testWithAnnotationsAndDataProvider(string $methodName): void
    {
        $test = (new TestBuilder)->build(new \ReflectionClass(\TestWithAnnotations::class), $methodName);
        $this->assertInstanceOf(DataProviderTestSuite::class, $test);
    }

    public function provideWithAnnotationsAndDataProvider(): array
    {
        return [
            ['testThatInteractsWithGlobalVariablesWithDataProvider'],
            ['testThatInteractsWithStaticAttributesWithDataProvider'],
            ['testInSeparateProcessWithDataProvider'],
        ];
    }
}
