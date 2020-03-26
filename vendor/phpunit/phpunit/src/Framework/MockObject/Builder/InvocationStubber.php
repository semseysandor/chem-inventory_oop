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
namespace PHPUnit\Framework\MockObject\Builder;

use PHPUnit\Framework\MockObject\Stub\Stub;

interface InvocationStubber
{
    public function will(Stub $stub): Identity;

    /** @return self */
    public function willReturn($value, ...$nextValues)/*: self */;

    /**
     * @param mixed $reference
     *
     * @return self
     */
    public function willReturnReference(&$reference)/*: self */;

    /**
     * @param array<int, array<int, mixed>> $valueMap
     *
     * @return self
     */
    public function willReturnMap(array $valueMap)/*: self */;

    /**
     * @param int $argumentIndex
     *
     * @return self
     */
    public function willReturnArgument($argumentIndex)/*: self */;

    /**
     * @param callable $callback
     *
     * @return self
     */
    public function willReturnCallback($callback)/*: self */;

    /** @return self */
    public function willReturnSelf()/*: self */;

    /**
     * @param mixed $values
     *
     * @return self
     */
    public function willReturnOnConsecutiveCalls(...$values)/*: self */;

    /** @return self */
    public function willThrowException(\Throwable $exception)/*: self */;
}
