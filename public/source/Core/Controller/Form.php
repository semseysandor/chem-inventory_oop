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

namespace Inventory\Core\Controller;

use Inventory\Core\Containers\Service;
use Inventory\Core\Containers\Template;

/**
 * Base Form Class
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Form extends BaseController
{
    /**
     * Error flag
     *
     * @var bool
     */
    protected bool $errorFlag;

    /**
     * Form response
     *
     * @var string
     */
    protected string $response;

    /**
     * Form constructor.
     *
     * @param array|null $request_data Request data
     * @param \Inventory\Core\Containers\Template $temp_cont Template container
     * @param \Inventory\Core\Containers\Service $service Service container
     */
    public function __construct(?array $request_data, Template $temp_cont, Service $service)
    {
        parent::__construct($request_data, $temp_cont, $service);
        $this->errorFlag = false;
        $this->response = '';
    }
}
