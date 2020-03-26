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

use Prophecy\Exception\InvalidArgumentException;

/**
 * Value type token.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class TypeToken implements TokenInterface
{
    private $type;

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $checker = "is_{$type}";
        if (!function_exists($checker) && !interface_exists($type) && !class_exists($type)) {
            throw new InvalidArgumentException(sprintf(
                'Type or class name expected as an argument to TypeToken, but got %s.', $type
            ));
        }

        $this->type = $type;
    }

    /**
     * Scores 5 if argument has the same type this token was constructed with.
     *
     * @param $argument
     *
     * @return bool|int
     */
    public function scoreArgument($argument)
    {
        $checker = "is_{$this->type}";
        if (function_exists($checker)) {
            return call_user_func($checker, $argument) ? 5 : false;
        }

        return $argument instanceof $this->type ? 5 : false;
    }

    /**
     * Returns false.
     *
     * @return bool
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
        return sprintf('type(%s)', $this->type);
    }
}
