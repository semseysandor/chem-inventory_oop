<?php

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

namespace Prophecy\Promise;

use Prophecy\Exception\InvalidArgumentException;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophecy\MethodProphecy;

/**
 * Return argument promise.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class ReturnArgumentPromise implements PromiseInterface
{
    /**
     * @var int
     */
    private $index;

    /**
     * Initializes callback promise.
     *
     * @param int $index The zero-indexed number of the argument to return
     *
     * @throws \Prophecy\Exception\InvalidArgumentException
     */
    public function __construct($index = 0)
    {
        if (!is_int($index) || $index < 0) {
            throw new InvalidArgumentException(sprintf(
                'Zero-based index expected as argument to ReturnArgumentPromise, but got %s.',
                $index
            ));
        }
        $this->index = $index;
    }

    /**
     * Returns nth argument if has one, null otherwise.
     *
     * @param array          $args
     * @param ObjectProphecy $object
     * @param MethodProphecy $method
     *
     * @return null|mixed
     */
    public function execute(array $args, ObjectProphecy $object, MethodProphecy $method)
    {
        return count($args) > $this->index ? $args[$this->index] : null;
    }
}
