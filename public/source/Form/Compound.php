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

namespace Inventory\Form;

use Inventory\Core\Controller\Form;
use Inventory\Core\Utils;

/**
 * Compound Form Class
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Compound extends Form
{
    /**
     * Validate input
     */
    protected function validate(): void
    {
        parent::validate();

        // Check CSRF token
        $this->token = $this->requestData['token'] ?? '';

        if (!$this->validateToken($this->token)) {
            $this->returnNoContent();
        }

        // Token valid --> remove from further processing
        unset($this->requestData['token']);

        // Sanitize data
        foreach ($this->requestData as $index => $item) {
            $this->requestData[$index] = Utils::sanitizeString($item);

            if (empty($this->requestData[$index])) {
                unset($this->requestData[$index]);
            }
        }

        // Check for required fields
        if (!isset($this->requestData['name'])) {
            $this->returnNoContent();
        }
    }

    /**
     * Process input
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function process(): void
    {
        parent::process();

        $bao = $this->getBaO(\Inventory\Entity\Compound\BAO\Compound::class);

        $affected_rows = $bao->insertCompound($this->requestData);

        if ($affected_rows === 1) {
            $this->response = ts('Compound created');
        } else {
            $this->response = ts('Failed to create compound');
        }
    }

    /**
     * Assemble page
     */
    protected function assemble(): void
    {
        parent::assemble();
        header('Content-Type: application/json');

        $this->templateContainer->setBase('ajax');
        $this->templateContainer->setVars('flag', ($this->errorFlag ? 'neg' : 'pos'));
        $this->templateContainer->setVars('text', $this->response);
    }
}
