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

namespace Inventory\Core\Controller;

use Inventory\Core\Containers\Template;
use Inventory\Core\Factory;

/**
 * Base Page Controller
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
abstract class Page extends BaseController
{
    /**
     * Page constructor.
     *
     * @param array|null $request_data Request data
     * @param \Inventory\Core\Containers\Template $temp_cont Template container
     * @param \Inventory\Core\Factory $factory Factory
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct(?array $request_data, Template $temp_cont, Factory $factory)
    {
        parent::__construct($request_data, $temp_cont, $factory);

        // Set base template for page
        $this->setBaseTemplate('page');
    }
}
