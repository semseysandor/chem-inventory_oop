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
namespace PHPUnit\Framework\MockObject\Rule;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsAnything;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\MockObject\Invocation as BaseInvocation;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class Parameters implements ParametersRule
{
    /**
     * @var Constraint[]
     */
    private $parameters = [];

    /**
     * @var BaseInvocation
     */
    private $invocation;

    /**
     * @var bool|ExpectationFailedException
     */
    private $parameterVerificationResult;

    /**
     * @throws \PHPUnit\Framework\Exception
     */
    public function __construct(array $parameters)
    {
        foreach ($parameters as $parameter) {
            if (!($parameter instanceof Constraint)) {
                $parameter = new IsEqual(
                    $parameter
                );
            }

            $this->parameters[] = $parameter;
        }
    }

    public function toString(): string
    {
        $text = 'with parameter';

        foreach ($this->parameters as $index => $parameter) {
            if ($index > 0) {
                $text .= ' and';
            }

            $text .= ' ' . $index . ' ' . $parameter->toString();
        }

        return $text;
    }

    /**
     * @throws \Exception
     */
    public function apply(BaseInvocation $invocation): void
    {
        $this->invocation                  = $invocation;
        $this->parameterVerificationResult = null;

        try {
            $this->parameterVerificationResult = $this->doVerify();
        } catch (ExpectationFailedException $e) {
            $this->parameterVerificationResult = $e;

            throw $this->parameterVerificationResult;
        }
    }

    /**
     * Checks if the invocation $invocation matches the current rules. If it
     * does the rule will get the invoked() method called which should check
     * if an expectation is met.
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function verify(): void
    {
        $this->doVerify();
    }

    /**
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    private function doVerify(): bool
    {
        if (isset($this->parameterVerificationResult)) {
            return $this->guardAgainstDuplicateEvaluationOfParameterConstraints();
        }

        if ($this->invocation === null) {
            throw new ExpectationFailedException('Mocked method does not exist.');
        }

        if (\count($this->invocation->getParameters()) < \count($this->parameters)) {
            $message = 'Parameter count for invocation %s is too low.';

            // The user called `->with($this->anything())`, but may have meant
            // `->withAnyParameters()`.
            //
            // @see https://github.com/sebastianbergmann/phpunit-mock-objects/issues/199
            if (\count($this->parameters) === 1 &&
                \get_class($this->parameters[0]) === IsAnything::class) {
                $message .= "\nTo allow 0 or more parameters with any value, omit ->with() or use ->withAnyParameters() instead.";
            }

            throw new ExpectationFailedException(
                \sprintf($message, $this->invocation->toString())
            );
        }

        foreach ($this->parameters as $i => $parameter) {
            $parameter->evaluate(
                $this->invocation->getParameters()[$i],
                \sprintf(
                    'Parameter %s for invocation %s does not match expected ' .
                    'value.',
                    $i,
                    $this->invocation->toString()
                )
            );
        }

        return true;
    }

    /**
     * @throws ExpectationFailedException
     */
    private function guardAgainstDuplicateEvaluationOfParameterConstraints(): bool
    {
        if ($this->parameterVerificationResult instanceof ExpectationFailedException) {
            throw $this->parameterVerificationResult;
        }

        return (bool) $this->parameterVerificationResult;
    }
}
