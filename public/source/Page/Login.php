<?php
/**
 +---------------------------------------------------------------------+
 | This file is part of chem-inventory.                                |
 |                                                                     |
 | Copyright (c) 2020 Sandor Semsey                                    |
 | All rights reserved.                                                |
 |                                                                     |
 | This work is published under the MIT License.                       |
 | https://choosealicense.com/licenses/mit/                            |
 |                                                                     |
 | It's a free software;)                                              |
 |                                                                     |
 | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 | SOFTWARE.                                                           |
 +---------------------------------------------------------------------+
 */

namespace Inventory\Page;

use Inventory\Core\Controller\Page;
use Inventory\Core\Utils;

/**
 * Login Class
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Login extends Page
{
    /**
     * Login form
     *
     * @var \Inventory\Form\Login|null
     */
    private \Inventory\Form\Login $form;

    public function __construct()
    {
        parent::__construct();
        $this->form = new \Inventory\Form\Login();
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
     * Process input
     *
     * @return void
     */
    protected function process(): void
    {
    }

    /**
     * Assemble page
     *
     * @return void
     */
    protected function assemble(): void
    {
        $this->addTemplateRegion('body', Utils::getPathFromClass($this));
        $this->addTemplateRegion('form', Utils::getPathFromClass($this->form));
    }
}