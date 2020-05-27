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

namespace Inventory\Page;

use Inventory\Core\Controller\Page;

/**
 * Forms Controller
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Forms extends Page
{
    /**
     * Allowed form types
     */
    public const ALLOWED_FORM_TYPES = ['add', 'edit'];

    /**
     * Allowed entities
     */
    public const ALLOWED_ENTITIES = ['compound'];

    /**
     * Form type
     *
     * @var string
     */
    private string $type;

    /**
     * Form entity
     *
     * @var string
     */
    private string $entity;

    /**
     * Validate input
     */
    protected function validate(): void
    {
        parent::validate();

        $this->type = $this->routeParams['type'] ?? '';
        $this->entity = $this->routeParams['entity'] ?? '';

        // No content if not allowed type or entity
        if (!in_array($this->type, self::ALLOWED_FORM_TYPES) || !in_array($this->entity, self::ALLOWED_ENTITIES)) {
            $this->returnNoContent();
        }
    }

    /**
     * Assemble page
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function assemble(): void
    {
        parent::assemble();

        // Construct template file name
        $template = ucfirst($this->entity).'/'.ucfirst($this->type);
        $template = "Form/{$template}";

        $this->templateContainer->setBase($template);

        // Add CSRF token
        $this->setTemplateVar('token', $_SESSION['TOKEN']);
    }
}
