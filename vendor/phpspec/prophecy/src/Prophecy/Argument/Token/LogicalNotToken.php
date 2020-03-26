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
 * Logical NOT token.
 *
 * @author Boris Mikhaylov <kaguxmail@gmail.com>
 */
class LogicalNotToken implements TokenInterface
{
    /** @var \Prophecy\Argument\Token\TokenInterface  */
    private $token;

    /**
     * @param mixed $value exact value or token
     */
    public function __construct($value)
    {
        $this->token = $value instanceof TokenInterface? $value : new ExactValueToken($value);
    }

    /**
     * Scores 4 when preset token does not match the argument.
     *
     * @param $argument
     *
     * @return bool|int
     */
    public function scoreArgument($argument)
    {
        return false === $this->token->scoreArgument($argument) ? 4 : false;
    }

    /**
     * Returns true if preset token is last.
     *
     * @return bool|int
     */
    public function isLast()
    {
        return $this->token->isLast();
    }

    /**
     * Returns originating token.
     *
     * @return TokenInterface
     */
    public function getOriginatingToken()
    {
        return $this->token;
    }

    /**
     * Returns string representation for token.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('not(%s)', $this->token);
    }
}
