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
use PHPUnit\Framework\TestCase;

class Issue1351Test extends TestCase
{
    protected $instance;

    /**
     * @runInSeparateProcess
     */
    public function testFailurePre(): void
    {
        $this->instance = new ChildProcessClass1351;
        $this->assertFalse(true, 'Expected failure.');
    }

    public function testFailurePost(): void
    {
        $this->assertNull($this->instance);
        $this->assertFalse(\class_exists(ChildProcessClass1351::class, false), 'ChildProcessClass1351 is not loaded.');
    }

    /**
     * @runInSeparateProcess
     */
    public function testExceptionPre(): void
    {
        $this->instance = new ChildProcessClass1351;

        try {
            throw new LogicException('Expected exception.');
        } catch (LogicException $e) {
            throw new RuntimeException('Expected rethrown exception.', 0, $e);
        }
    }

    public function testExceptionPost(): void
    {
        $this->assertNull($this->instance);
        $this->assertFalse(\class_exists(ChildProcessClass1351::class, false), 'ChildProcessClass1351 is not loaded.');
    }

    public function testPhpCoreLanguageException(): void
    {
        // User-space code cannot instantiate a PDOException with a string code,
        // so trigger a real one.
        $connection = new PDO('sqlite::memory:');
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->query("DELETE FROM php_wtf WHERE exception_code = 'STRING'");
    }
}
