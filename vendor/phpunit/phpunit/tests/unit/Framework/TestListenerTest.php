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

use MyTestListener;

/**
 * @small
 */
final class TestListenerTest extends TestCase
{
    /**
     * @var TestResult
     */
    private $result;

    /**
     * @var MyTestListener
     */
    private $listener;

    protected function setUp(): void
    {
        $this->result   = new TestResult;
        $this->listener = new MyTestListener;

        $this->result->addListener($this->listener);
    }

    public function testError(): void
    {
        $test = new \TestError;
        $test->run($this->result);

        $this->assertEquals(1, $this->listener->errorCount());
        $this->assertEquals(1, $this->listener->endCount());
    }

    public function testFailure(): void
    {
        $test = new \Failure;
        $test->run($this->result);

        $this->assertEquals(1, $this->listener->failureCount());
        $this->assertEquals(1, $this->listener->endCount());
    }

    public function testStartStop(): void
    {
        $test = new \Success;
        $test->run($this->result);

        $this->assertEquals(1, $this->listener->startCount());
        $this->assertEquals(1, $this->listener->endCount());
    }
}
