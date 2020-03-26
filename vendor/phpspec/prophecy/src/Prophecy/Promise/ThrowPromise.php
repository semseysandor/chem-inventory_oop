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

use Doctrine\Instantiator\Instantiator;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Exception\InvalidArgumentException;
use ReflectionClass;

/**
 * Throw promise.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class ThrowPromise implements PromiseInterface
{
    private $exception;

    /**
     * @var \Doctrine\Instantiator\Instantiator
     */
    private $instantiator;

    /**
     * Initializes promise.
     *
     * @param string|\Exception|\Throwable $exception Exception class name or instance
     *
     * @throws \Prophecy\Exception\InvalidArgumentException
     */
    public function __construct($exception)
    {
        if (is_string($exception)) {
            if ((!class_exists($exception) && !interface_exists($exception)) || !$this->isAValidThrowable($exception)) {
                throw new InvalidArgumentException(sprintf(
                    'Exception / Throwable class or instance expected as argument to ThrowPromise, but got %s.',
                    $exception
                ));
            }
        } elseif (!$exception instanceof \Exception && !$exception instanceof \Throwable) {
            throw new InvalidArgumentException(sprintf(
                'Exception / Throwable class or instance expected as argument to ThrowPromise, but got %s.',
                is_object($exception) ? get_class($exception) : gettype($exception)
            ));
        }

        $this->exception = $exception;
    }

    /**
     * Throws predefined exception.
     *
     * @param array          $args
     * @param ObjectProphecy $object
     * @param MethodProphecy $method
     *
     * @throws object
     */
    public function execute(array $args, ObjectProphecy $object, MethodProphecy $method)
    {
        if (is_string($this->exception)) {
            $classname   = $this->exception;
            $reflection  = new ReflectionClass($classname);
            $constructor = $reflection->getConstructor();

            if ($constructor->isPublic() && 0 == $constructor->getNumberOfRequiredParameters()) {
                throw $reflection->newInstance();
            }

            if (!$this->instantiator) {
                $this->instantiator = new Instantiator();
            }

            throw $this->instantiator->instantiate($classname);
        }

        throw $this->exception;
    }

    /**
     * @param string $exception
     *
     * @return bool
     */
    private function isAValidThrowable($exception)
    {
        return is_a($exception, 'Exception', true)
            || is_a($exception, 'Throwable', true);
    }
}
