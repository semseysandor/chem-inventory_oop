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
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

/**
 * @small
 */
final class DirectoryExistsTest extends ConstraintTestCase
{
    public function testDefaults(): void
    {
        $constraint = new DirectoryExists;

        $this->assertCount(1, $constraint);
        $this->assertSame('directory exists', $constraint->toString());
    }

    public function testEvaluateReturnsFalseWhenDirectoryDoesNotExist(): void
    {
        $directory = __DIR__ . '/NonExistentDirectory';

        $constraint = new DirectoryExists;

        $this->assertFalse($constraint->evaluate($directory, '', true));
    }

    public function testEvaluateReturnsTrueWhenDirectoryExists(): void
    {
        $directory = __DIR__;

        $constraint = new DirectoryExists;

        $this->assertTrue($constraint->evaluate($directory, '', true));
    }

    public function testEvaluateThrowsExpectationFailedExceptionWhenDirectoryDoesNotExist(): void
    {
        $directory = __DIR__ . '/NonExistentDirectory';

        $constraint = new DirectoryExists;

        try {
            $constraint->evaluate($directory);
        } catch (ExpectationFailedException $e) {
            $this->assertSame(
                <<<PHP
Failed asserting that directory "$directory" exists.

PHP
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
