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
     * Static error page path
     */
    public const STATIC_ERROR_PAGE = ROOT.'/templates/static/error.phtml';

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
    public function setRenderer(Renderer $renderer): void
    {
        $this->renderer = $renderer;
    }

    /**
     * Handles renderer error
     *
     * @param \Inventory\Core\Exception\BaseException $ex Exception to handle
     */
    public function handleRenderingError(BaseException $ex): void
    {
        $this->displayStaticError($ex);
        $this->exitWithFail($ex->getCode());
    }

    /**
     * Handles fatal error
     *
     * @param \Inventory\Core\Exception\BaseException $ex
     */
    public function handleFatalError(BaseException $ex): void
    {
        // No renderer --> fallback to static error page
        if (is_null($this->renderer)) {
            $this->displayStaticError($ex);
        } else {
            // There is a renderer --> use it to display error
            try {
                $this->renderer->displayError($ex);
            } catch (RenderingError $ex) {
                // Rendering error --> static display
                $this->displayStaticError($ex);
            }
        }

        // Exit application
        $this->exitWithFail($ex->getCode());
    }

    /**
     * Display static error page
     *
     * @param \Inventory\Core\Exception\BaseException $ex
     */
    protected function displayStaticError(BaseException $ex): void
    {
        $message = $ex->getMessage();
        $context = $ex->getContext();
        $trace = $ex->getTrace();

        include self::STATIC_ERROR_PAGE;
    }

    /**
     * Exit with error code
     *
     * @param int $code Error code
     */
    public function exitWithFail(int $code = 1): void
    {
        // Don't allow zero or negative status codes
        if ($code < 1) {
            $code = 1;
        }
        exit($code);
    }
}
