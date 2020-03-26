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
 * Object state-checker token.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class ObjectStateToken implements TokenInterface
{
    private $name;
    private $value;
    private $util;
    private $comparatorFactory;

    /**
     * Initializes token.
     *
     * @param string            $methodName
     * @param mixed             $value             Expected return value
     * @param null|StringUtil   $util
     * @param ComparatorFactory $comparatorFactory
     */
    public function __construct(
        $methodName,
        $value,
        StringUtil $util = null,
        ComparatorFactory $comparatorFactory = null
    ) {
        $this->name  = $methodName;
        $this->value = $value;
        $this->util  = $util ?: new StringUtil;

        $this->comparatorFactory = $comparatorFactory ?: ComparatorFactory::getInstance();
    }

    /**
     * Scores 8 if argument is an object, which method returns expected value.
     *
     * @param mixed $argument
     *
     * @return bool|int
     */
    public function scoreArgument($argument)
    {
        if (is_object($argument) && method_exists($argument, $this->name)) {
            $actual = call_user_func(array($argument, $this->name));

            $comparator = $this->comparatorFactory->getComparatorFor(
                $this->value, $actual
            );

            try {
                $comparator->assertEquals($this->value, $actual);
                return 8;
            } catch (ComparisonFailure $failure) {
                return false;
            }
        }

        if (is_object($argument) && property_exists($argument, $this->name)) {
            return $argument->{$this->name} === $this->value ? 8 : false;
        }

        return false;
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
        return sprintf('state(%s(), %s)',
            $this->name,
            $this->util->stringify($this->value)
        );
    }
}
