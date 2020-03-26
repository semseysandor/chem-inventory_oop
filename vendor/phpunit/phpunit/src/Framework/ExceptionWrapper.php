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
namespace PHPUnit\Framework;

use PHPUnit\Util\Filter;
use Throwable;

/**
 * Wraps Exceptions thrown by code under test.
 *
 * Re-instantiates Exceptions thrown by user-space code to retain their original
 * class names, properties, and stack traces (but without arguments).
 *
 * Unlike PHPUnit\Framework_\Exception, the complete stack of previous Exceptions
 * is processed.
 *
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class ExceptionWrapper extends Exception
{
    /**
     * @var string
     */
    protected $className;

    /**
     * @var null|ExceptionWrapper
     */
    protected $previous;

    public function __construct(Throwable $t)
    {
        // PDOException::getCode() is a string.
        // @see https://php.net/manual/en/class.pdoexception.php#95812
        parent::__construct($t->getMessage(), (int) $t->getCode());
        $this->setOriginalException($t);
    }

    public function __toString(): string
    {
        $string = TestFailure::exceptionToString($this);

        if ($trace = Filter::getFilteredStacktrace($this)) {
            $string .= "\n" . $trace;
        }

        if ($this->previous) {
            $string .= "\nCaused by\n" . $this->previous;
        }

        return $string;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getPreviousWrapped(): ?self
    {
        return $this->previous;
    }

    public function setClassName(string $className): void
    {
        $this->className = $className;
    }

    public function setOriginalException(\Throwable $t): void
    {
        $this->originalException($t);

        $this->className = \get_class($t);
        $this->file      = $t->getFile();
        $this->line      = $t->getLine();

        $this->serializableTrace = $t->getTrace();

        foreach (\array_keys($this->serializableTrace) as $key) {
            unset($this->serializableTrace[$key]['args']);
        }

        if ($t->getPrevious()) {
            $this->previous = new self($t->getPrevious());
        }
    }

    public function getOriginalException(): ?Throwable
    {
        return $this->originalException();
    }

    /**
     * Method to contain static originalException to exclude it from stacktrace to prevent the stacktrace contents,
     * which can be quite big, from being garbage-collected, thus blocking memory until shutdown.
     * Approach works both for var_dump() and var_export() and print_r()
     */
    private function originalException(Throwable $exceptionToStore = null): ?Throwable
    {
        static $originalExceptions;

        $instanceId = \spl_object_hash($this);

        if ($exceptionToStore) {
            $originalExceptions[$instanceId] = $exceptionToStore;
        }

        return $originalExceptions[$instanceId] ?? null;
    }
}
