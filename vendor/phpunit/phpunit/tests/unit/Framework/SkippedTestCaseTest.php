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

use PHPUnit\Runner\BaseTestRunner;

final class SkippedTestCaseTest extends TestCase
{
    public function testDefaults(): void
    {
        $testCase = new SkippedTestCase(
            'Foo',
            'testThatBars'
        );

        $this->assertSame('', $testCase->getMessage());
    }

    public function testGetNameReturnsClassAndMethodName(): void
    {
        $className  = 'Foo';
        $methodName = 'testThatBars';

        $testCase = new SkippedTestCase(
            $className,
            $methodName
        );

        $name = \sprintf(
            '%s::%s',
            $className,
            $methodName
        );

        $this->assertSame($name, $testCase->getName());
    }

    public function testGetMessageReturnsMessage(): void
    {
        $message = 'Somehow skipped, right?';

        $testCase = new SkippedTestCase(
            'Foo',
            'testThatBars',
            $message
        );

        $this->assertSame($message, $testCase->getMessage());
    }

    public function testRunMarksTestAsSkipped(): void
    {
        $className  = 'Foo';
        $methodName = 'testThatBars';
        $message    = 'Somehow skipped, right?';

        $testCase = new SkippedTestCase(
            $className,
            $methodName,
            $message
        );

        $result = $testCase->run();

        $this->assertSame(BaseTestRunner::STATUS_SKIPPED, $testCase->getStatus());
        $this->assertSame(1, $result->skippedCount());

        $failures = $result->skipped();

        $failure = \array_shift($failures);

        $name = \sprintf(
            '%s::%s',
            $className,
            $methodName
        );

        $this->assertSame($name, $failure->getTestName());
        $this->assertSame($message, $failure->exceptionMessage());
    }
}
