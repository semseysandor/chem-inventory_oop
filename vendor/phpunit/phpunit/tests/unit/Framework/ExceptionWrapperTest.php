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

/**
 * @small
 */
final class ExceptionWrapperTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testGetOriginalException(): void
    {
        $e       = new \BadFunctionCallException('custom class exception');
        $wrapper = new ExceptionWrapper($e);

        $this->assertInstanceOf(\BadFunctionCallException::class, $wrapper->getOriginalException());
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetOriginalExceptionWithPrevious(): void
    {
        $e       = new \BadFunctionCallException('custom class exception', 0, new \Exception('previous'));
        $wrapper = new ExceptionWrapper($e);

        $this->assertInstanceOf(\BadFunctionCallException::class, $wrapper->getOriginalException());
    }

    /**
     * @runInSeparateProcess
     */
    public function testNoOriginalExceptionInStacktrace(): void
    {
        $e       = new \BadFunctionCallException('custom class exception');
        $wrapper = new ExceptionWrapper($e);

        // Replace the only mention of "BadFunctionCallException" in wrapper
        $wrapper->setClassName('MyException');

        $data = \print_r($wrapper, true);

        $this->assertStringNotContainsString(
            'BadFunctionCallException',
            $data,
            'Assert there is s no other BadFunctionCallException mention in stacktrace'
        );
    }
}
