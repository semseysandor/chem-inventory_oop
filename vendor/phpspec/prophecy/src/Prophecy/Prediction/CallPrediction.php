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

namespace Prophecy\Prediction;

use Prophecy\Call\Call;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Argument\ArgumentsWildcard;
use Prophecy\Argument\Token\AnyValuesToken;
use Prophecy\Util\StringUtil;
use Prophecy\Exception\Prediction\NoCallsException;

/**
 * Call prediction.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class CallPrediction implements PredictionInterface
{
    private $util;

    /**
     * Initializes prediction.
     *
     * @param StringUtil $util
     */
    public function __construct(StringUtil $util = null)
    {
        $this->util = $util ?: new StringUtil;
    }

    /**
     * Tests that there was at least one call.
     *
     * @param Call[]         $calls
     * @param ObjectProphecy $object
     * @param MethodProphecy $method
     *
     * @throws \Prophecy\Exception\Prediction\NoCallsException
     */
    public function check(array $calls, ObjectProphecy $object, MethodProphecy $method)
    {
        if (count($calls)) {
            return;
        }

        $methodCalls = $object->findProphecyMethodCalls(
            $method->getMethodName(),
            new ArgumentsWildcard(array(new AnyValuesToken))
        );

        if (count($methodCalls)) {
            throw new NoCallsException(sprintf(
                "No calls have been made that match:\n".
                "  %s->%s(%s)\n".
                "but expected at least one.\n".
                "Recorded `%s(...)` calls:\n%s",

                get_class($object->reveal()),
                $method->getMethodName(),
                $method->getArgumentsWildcard(),
                $method->getMethodName(),
                $this->util->stringifyCalls($methodCalls)
            ), $method);
        }

        throw new NoCallsException(sprintf(
            "No calls have been made that match:\n".
            "  %s->%s(%s)\n".
            "but expected at least one.",

            get_class($object->reveal()),
            $method->getMethodName(),
            $method->getArgumentsWildcard()
        ), $method);
    }
}
