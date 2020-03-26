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
     * Index constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Process input
     *
     * @return void
     */
    protected function process(): void
    {
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
     */
    protected function assemble(): void
    {
        $this->addTemplateRegion('body', Utils::getPathFromClass($this));

        $this->setTemplateVar('user', $_SESSION['USER_NAME']);
    }
}
