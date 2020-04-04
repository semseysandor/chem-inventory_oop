<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020                                |
 | Sandor Semsey <semseysandor@gmail.com>        |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

namespace Inventory\Core\Exception;

use Inventory\Core\Renderer;

/**
 * Exception Handler
 *
 * @category Exception
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class ExceptionHandler
{
    /**
     * Renderer
     *
     * @var \Inventory\Core\Renderer
     */
    private ?Renderer $renderer;

    /**
     * ExceptionHandler constructor.
     *
     * @param \Inventory\Core\Renderer|null $renderer Renderer
     */
    public function __construct(Renderer $renderer = null)
    {
        $this->renderer = $renderer;
    }

    /**
     * Set renderer
     *
     * @param \Inventory\Core\Renderer $renderer
     */
    public function setRenderer(Renderer $renderer)
    {
        $this->renderer=$renderer;
    }

    /**
     * Handles renderer error
     */
    public function handleRendererError(): void
    {
        $this->displayStaticError();
        $this->exitWithFail(1);
    }

    /**
     * Handles fatal error
     */
    public function handleFatalError():void
    {
        // There is a renderer --> use it
        if ($this->renderer) {
            // Display error
            $this->renderer->displayError();
        } else {
            // No renderer --> fallback to static error page
            $this->displayStaticError();
        }

        // Exit application
        $this->exitWithFail(1);
    }

    /**
     * Display static error page
     */
    protected function displayStaticError()
    {
        include ROOT.'/templates/static/error.html';
    }

    /**
     * Exit with error code
     *
     * @param int $code Error code
     */
    public function exitWithFail(int $code): void
    {
        // Don't allow zero or negative status codes
        if ($code < 1) {
            $code = 1;
        }
        exit($code);
    }
}
