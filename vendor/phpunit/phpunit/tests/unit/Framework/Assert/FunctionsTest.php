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

final class FunctionsTest extends TestCase
{
    private static $globalAssertionFunctions = [];

    public static function setUpBeforeClass(): void
    {
        \preg_match_all(
            '/function (assert[^ \(]+)/',
            \file_get_contents(
                __DIR__ . '/../../../../src/Framework/Assert/Functions.php'
            ),
            $matches
        );

        self::$globalAssertionFunctions = $matches[1];
    }

    /**
     * @dataProvider provideStaticAssertionMethodNames
     */
    public function testGlobalFunctionsFileContainsAllStaticAssertions(string $methodName): void
    {
        Assert::assertContains(
            $methodName,
            self::$globalAssertionFunctions,
            "Mapping for Assert::$methodName is missing in Functions.php"
        );
    }

    public function provideStaticAssertionMethodNames(): array
    {
        \preg_match_all(
            '/public static function (assert[^ \(]+)/',
            \file_get_contents(
                __DIR__ . '/../../../../src/Framework/Assert.php'
            ),
            $matches
        );

        return \array_reduce(
            $matches[1],
            function (array $functionNames, string $functionName) {
                $functionNames[$functionName] = [$functionName];

                return $functionNames;
            },
            []
        );
    }
}
