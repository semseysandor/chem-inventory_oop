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

namespace Prophecy\Argument\Token;

/**
 * Array elements count token.
 *
 * @author Boris Mikhaylov <kaguxmail@gmail.com>
 */

class ArrayCountToken implements TokenInterface
{
    private $count;

    /**
     * @param integer $value
     */
    public function __construct($value)
    {
        $this->count = $value;
    }

    /**
     * Scores 6 when argument has preset number of elements.
     *
     * @param $argument
     *
     * @return bool|int
     */
    public function scoreArgument($argument)
    {
        return $this->isCountable($argument) && $this->hasProperCount($argument) ? 6 : false;
    }

    /**
     * Returns false.
     *
     * @return boolean
     */
    public function isLast()
    {
        return false;
    }

    /**
     * Returns string representation for token.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('count(%s)', $this->count);
    }

    /**
     * Returns true if object is either array or instance of \Countable
     *
     * @param $argument
     * @return bool
     */
    private function isCountable($argument)
    {
        return (is_array($argument) || $argument instanceof \Countable);
    }

    /**
     * Returns true if $argument has expected number of elements
     *
     * @param array|\Countable $argument
     *
     * @return bool
     */
    private function hasProperCount($argument)
    {
        return $this->count === count($argument);
    }
}
