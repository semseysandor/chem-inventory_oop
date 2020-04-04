<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020 Sandor Semsey                  |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

namespace Inventory\Core\Exception;

/**
 * Bad Argument Exception
 *
 * @category Exception
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class BadArgument extends BaseException
{
    /**
     * Exception message
     */
    public const MESSAGE='Bad argument received.';
    /**
     * Bad Argument constructor.
     *
     * @param string|null $context Context in which exception appeared
     */
    public function __construct(string $context = null)
    {
        parent::__construct($context, ts(self::MESSAGE));
    }
}
