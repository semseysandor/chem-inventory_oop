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

use SebastianBergmann\Comparator\ComparisonFailure;
use Prophecy\Comparator\Factory as ComparatorFactory;
use Prophecy\Util\StringUtil;

/**
 * Exact value token.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class ExactValueToken implements TokenInterface
{
    private $value;
    private $string;
    private $util;
    private $comparatorFactory;

    /**
     * Initializes token.
     *
     * @param mixed             $value
     * @param StringUtil        $util
     * @param ComparatorFactory $comparatorFactory
     */
    public function __construct($value, StringUtil $util = null, ComparatorFactory $comparatorFactory = null)
    {
        $this->value = $value;
        $this->util  = $util ?: new StringUtil();

        $this->comparatorFactory = $comparatorFactory ?: ComparatorFactory::getInstance();
    }

    /**
     * Scores 10 if argument matches preset value.
     *
     * @param $argument
     *
     * @return bool|int
     */
    public function scoreArgument($argument)
    {
        if (is_object($argument) && is_object($this->value)) {
            $comparator = $this->comparatorFactory->getComparatorFor(
                $argument, $this->value
            );

            try {
                $comparator->assertEquals($argument, $this->value);
                return 10;
            } catch (ComparisonFailure $failure) {
            	return false;
			}
        }

        // If either one is an object it should be castable to a string
        if (is_object($argument) xor is_object($this->value)) {
            if (is_object($argument) && !method_exists($argument, '__toString')) {
                return false;
            }

            if (is_object($this->value) && !method_exists($this->value, '__toString')) {
                return false;
            }
        } elseif (is_numeric($argument) && is_numeric($this->value)) {
            // noop
        } elseif (gettype($argument) !== gettype($this->value)) {
            return false;
        }

        return $argument == $this->value ? 10 : false;
    }

    /**
     * Returns preset value against which token checks arguments.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
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
        if (null === $this->string) {
            $this->string = sprintf('exact(%s)', $this->util->stringify($this->value));
        }

        return $this->string;
    }
}
