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

namespace Inventory\Page;

use Error;
use Exception;
use Inventory\Core\Controller\Page;
use Inventory\Core\Exception\BaseException;
use Inventory\Core\Utils;
use Inventory\Entity\Compound\BAO\Compound;

/**
 * Index Class
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Index extends Page
{
    /**
     * Process input
     *
     * @return void
     */
    protected function process(): void
    {
        // TODO: implement more
        try {
            $bao = new Compound();
            $this->setTemplateVar('compounds', $bao->getAll(['id', 'name']));
        } catch (BaseException $ex) {
            echo $ex->getMessage().' '.$ex->getContext();
            exit;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        } catch (Error $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Validate input
     *
     * @return void
     */
    protected function validate(): void
    {
    }

    /**
     * Assemble page
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function assemble(): void
    {
        $this->setTemplateRegion('body', Utils::getPathFromClass(self::class));

        $this->setTemplateVar('user', $_SESSION['USER_NAME']);
    }
}
