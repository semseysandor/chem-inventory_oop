<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | (c) Sandor Semsey <semseysandor@gmail.com>    |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 |                                               |
 | It's a free software;)                        |
 +-----------------------------------------------+
 */

/**
 * +-----------------------------------------------+
 * | This file is part of chem-inventory.          |
 * |                                               |
 * | (c) Sandor Semsey <semseysandor@gmail.com>    |
 * | All rights reserved.                          |
 * |                                               |
 * | This work is published under the MIT License. |
 * | https://choosealicense.com/licenses/mit/      |
 * |                                               |
 * | It's a free software;)                        |
 * +-----------------------------------------------+
 */

namespace Inventory\Core\Exception;

use Exception;
use Throwable;

/**
 * Base class for Exceptions
 *
 * @category Exception
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class BaseException extends Exception
{
    /**
     * Context of the exception
     *
     * @var string
     */
    protected string $context;

    /**
     * Inventory Exception constructor.
     *
     * @param string|null $context Context of the exception
     * @param string $message Exception message
     * @param int $code Exception code
     * @param Throwable $previous Previous exception
     */
    public function __construct(string $context = null, string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    /**
     * Gets context
     *
     * @return string|null
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * Prints debug information
     */
    public function print(): void
    {
        // TODO: Exception string
        echo $this->getMessage()."\n".$this->getContext()."\n";
    }
}
