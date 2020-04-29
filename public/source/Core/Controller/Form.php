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
use Inventory\Core\Utils;

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
     * Form response
     *
     * @var string
     */
    protected string $response;

    /**
     * Form CS-RF token
     *
     * @var string
     */
    protected string $token;

    /**
     * Form constructor.
     *
     * @param array $route_params Route parameters
     * @param array $request_data Request data
     * @param \Inventory\Core\Containers\Template $temp_cont Template container
     * @param \Inventory\Core\Containers\Service $service Service container
     */
    public function __construct(array $route_params, array $request_data, Template $temp_cont, Service $service)
    {
        parent::__construct($route_params, $request_data, $temp_cont, $service);
        $this->response = '';
        $this->token = '';
    }

    /**
     * Validate session token from request
     *
     * @param string $token Token received
     *
     * @return bool
     */
    protected function validateToken(string $token): bool
    {
        $this->token = Utils::sanitizeString($token, 'hex');

        if ($this->token === $_SESSION['TOKEN']) {
            return true;
        }

        // Token not valid
        $this->errorFlag = true;
        $this->response = ts('Token mismatch.');

        return false;
    }
}
