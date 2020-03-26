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
namespace PHPUnit\Framework\MockObject;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\MockObject\Rule\AnyInvokedCount;
use PHPUnit\Framework\MockObject\Rule\AnyParameters;
use PHPUnit\Framework\MockObject\Rule\InvocationOrder;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use PHPUnit\Framework\MockObject\Rule\MethodName;
use PHPUnit\Framework\MockObject\Rule\ParametersRule;
use PHPUnit\Framework\MockObject\Stub\Stub;
use PHPUnit\Framework\TestFailure;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class Matcher
{
    /**
     * @var InvocationOrder
     */
    private $invocationRule;

    /**
     * @var mixed
     */
    private $afterMatchBuilderId;

    /**
     * @var bool
     */
    private $afterMatchBuilderIsInvoked = false;

    /**
     * @var MethodName
     */
    private $methodNameRule;

    /**
     * @var ParametersRule
     */
    private $parametersRule;

    /**
     * @var Stub
     */
    private $stub;

    public function __construct(InvocationOrder $rule)
    {
        $this->invocationRule = $rule;
    }

    public function hasMatchers(): bool
    {
        return !$this->invocationRule instanceof AnyInvokedCount;
    }

    public function hasMethodNameRule(): bool
    {
        return $this->methodNameRule !== null;
    }

    public function getMethodNameRule(): MethodName
    {
        return $this->methodNameRule;
    }

    public function setMethodNameRule(MethodName $rule): void
    {
        $this->methodNameRule = $rule;
    }

    public function hasParametersRule(): bool
    {
        return $this->parametersRule !== null;
    }

    public function setParametersRule(ParametersRule $rule): void
    {
        $this->parametersRule = $rule;
    }

    public function setStub(Stub $stub): void
    {
        $this->stub = $stub;
    }

    public function setAfterMatchBuilderId(string $id): void
    {
        $this->afterMatchBuilderId = $id;
    }

    /**
     * @throws \Exception
     * @throws RuntimeException
     * @throws ExpectationFailedException
     */
    public function invoked(Invocation $invocation)
    {
        if ($this->methodNameRule === null) {
            throw new RuntimeException('No method rule is set');
        }

        if ($this->afterMatchBuilderId !== null) {
            $matcher = $invocation->getObject()
                                  ->__phpunit_getInvocationHandler()
                                  ->lookupMatcher($this->afterMatchBuilderId);

            if (!$matcher) {
                throw new RuntimeException(
                    \sprintf(
                        'No builder found for match builder identification <%s>',
                        $this->afterMatchBuilderId
                    )
                );
            }
            \assert($matcher instanceof self);

            if ($matcher->invocationRule->hasBeenInvoked()) {
                $this->afterMatchBuilderIsInvoked = true;
            }
        }

        $this->invocationRule->invoked($invocation);

        try {
            if ($this->parametersRule !== null) {
                $this->parametersRule->apply($invocation);
            }
        } catch (ExpectationFailedException $e) {
            throw new ExpectationFailedException(
                \sprintf(
                    "Expectation failed for %s when %s\n%s",
                    $this->methodNameRule->toString(),
                    $this->invocationRule->toString(),
                    $e->getMessage()
                ),
                $e->getComparisonFailure()
            );
        }

        if ($this->stub) {
            return $this->stub->invoke($invocation);
        }

        return $invocation->generateReturnValue();
    }

    /**
     * @throws RuntimeException
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function matches(Invocation $invocation): bool
    {
        if ($this->afterMatchBuilderId !== null) {
            $matcher = $invocation->getObject()
                                  ->__phpunit_getInvocationHandler()
                                  ->lookupMatcher($this->afterMatchBuilderId);

            if (!$matcher) {
                throw new RuntimeException(
                    \sprintf(
                        'No builder found for match builder identification <%s>',
                        $this->afterMatchBuilderId
                    )
                );
            }
            \assert($matcher instanceof self);

            if (!$matcher->invocationRule->hasBeenInvoked()) {
                return false;
            }
        }

        if ($this->methodNameRule === null) {
            throw new RuntimeException('No method rule is set');
        }

        if (!$this->invocationRule->matches($invocation)) {
            return false;
        }

        try {
            if (!$this->methodNameRule->matches($invocation)) {
                return false;
            }
        } catch (ExpectationFailedException $e) {
            throw new ExpectationFailedException(
                \sprintf(
                    "Expectation failed for %s when %s\n%s",
                    $this->methodNameRule->toString(),
                    $this->invocationRule->toString(),
                    $e->getMessage()
                ),
                $e->getComparisonFailure()
            );
        }

        return true;
    }

    /**
     * @throws RuntimeException
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function verify(): void
    {
        if ($this->methodNameRule === null) {
            throw new RuntimeException('No method rule is set');
        }

        try {
            $this->invocationRule->verify();

            if ($this->parametersRule === null) {
                $this->parametersRule = new AnyParameters;
            }

            $invocationIsAny   = $this->invocationRule instanceof AnyInvokedCount;
            $invocationIsNever = $this->invocationRule instanceof InvokedCount && $this->invocationRule->isNever();

            if (!$invocationIsAny && !$invocationIsNever) {
                $this->parametersRule->verify();
            }
        } catch (ExpectationFailedException $e) {
            throw new ExpectationFailedException(
                \sprintf(
                    "Expectation failed for %s when %s.\n%s",
                    $this->methodNameRule->toString(),
                    $this->invocationRule->toString(),
                    TestFailure::exceptionToString($e)
                )
            );
        }
    }

    public function toString(): string
    {
        $list = [];

        if ($this->invocationRule !== null) {
            $list[] = $this->invocationRule->toString();
        }

        if ($this->methodNameRule !== null) {
            $list[] = 'where ' . $this->methodNameRule->toString();
        }

        if ($this->parametersRule !== null) {
            $list[] = 'and ' . $this->parametersRule->toString();
        }

        if ($this->afterMatchBuilderId !== null) {
            $list[] = 'after ' . $this->afterMatchBuilderId;
        }

        if ($this->stub !== null) {
            $list[] = 'will ' . $this->stub->toString();
        }

        return \implode(' ', $list);
    }
}
