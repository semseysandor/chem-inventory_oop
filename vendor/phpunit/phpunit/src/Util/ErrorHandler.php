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
namespace PHPUnit\Util;

use PHPUnit\Framework\Error\Deprecated;
use PHPUnit\Framework\Error\Error;
use PHPUnit\Framework\Error\Notice;
use PHPUnit\Framework\Error\Warning;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class ErrorHandler
{
    /**
     * @var bool
     */
    private $convertDeprecationsToExceptions;

    /**
     * @var bool
     */
    private $convertErrorsToExceptions;

    /**
     * @var bool
     */
    private $convertNoticesToExceptions;

    /**
     * @var bool
     */
    private $convertWarningsToExceptions;

    /**
     * @var bool
     */
    private $registered = false;

    public static function invokeIgnoringWarnings(callable $callable)
    {
        \set_error_handler(
            static function ($errorNumber, $errorString) {
                if ($errorNumber === \E_WARNING) {
                    return;
                }

                return false;
            }
        );

        $result = $callable();

        \restore_error_handler();

        return $result;
    }

    public function __construct(bool $convertDeprecationsToExceptions, bool $convertErrorsToExceptions, bool $convertNoticesToExceptions, bool $convertWarningsToExceptions)
    {
        $this->convertDeprecationsToExceptions = $convertDeprecationsToExceptions;
        $this->convertErrorsToExceptions       = $convertErrorsToExceptions;
        $this->convertNoticesToExceptions      = $convertNoticesToExceptions;
        $this->convertWarningsToExceptions     = $convertWarningsToExceptions;
    }

    public function __invoke(int $errorNumber, string $errorString, string $errorFile, int $errorLine): bool
    {
        /*
         * Do not raise an exception when the error suppression operator (@) was used.
         *
         * @see https://github.com/sebastianbergmann/phpunit/issues/3739
         */
        if (!($errorNumber & \error_reporting())) {
            return false;
        }

        switch ($errorNumber) {
            case \E_NOTICE:
            case \E_USER_NOTICE:
            case \E_STRICT:
                if (!$this->convertNoticesToExceptions) {
                    return false;
                }

                throw new Notice($errorString, $errorNumber, $errorFile, $errorLine);

            case \E_WARNING:
            case \E_USER_WARNING:
                if (!$this->convertWarningsToExceptions) {
                    return false;
                }

                throw new Warning($errorString, $errorNumber, $errorFile, $errorLine);

            case \E_DEPRECATED:
            case \E_USER_DEPRECATED:
                if (!$this->convertDeprecationsToExceptions) {
                    return false;
                }

                throw new Deprecated($errorString, $errorNumber, $errorFile, $errorLine);

            default:
                if (!$this->convertErrorsToExceptions) {
                    return false;
                }

                throw new Error($errorString, $errorNumber, $errorFile, $errorLine);
        }
    }

    public function register(): void
    {
        if ($this->registered) {
            return;
        }

        $oldErrorHandler = \set_error_handler($this);

        if ($oldErrorHandler !== null) {
            \restore_error_handler();

            return;
        }

        $this->registered = true;
    }

    public function unregister(): void
    {
        if (!$this->registered) {
            return;
        }

        \restore_error_handler();
    }
}
