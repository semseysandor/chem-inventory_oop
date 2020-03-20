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
use Inventory\Compound\BAO\Compound;
use Inventory\Core\Controller\CoreController;
use Inventory\Core\Exception\InventoryException;

class Index extends CoreController
{
    protected function process()
    {
        try {
            $bao = new Compound();
            $this->assignTemplateVar('compounds', $bao->getAll(['id', 'name']));
        } catch (InventoryException $ex) {
            echo $ex->getMessage().' '.$ex->getContext();
            exit;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        } catch (Error $ex) {
            echo $ex->getMessage();
        }
        parent::process();
    }

    protected function assemble()
    {
        $class_name = str_replace('\\', '/', __CLASS__);
        $class_name = substr($class_name, 10);

        $this->setBaseTemplate('page');
        $this->setTemplateRegion('body', $class_name);

        $this->assignTemplateVar('majom', 'beco');
        $this->assignTemplateVar('kutya', ['maki', 'lali', 'papi']);

        parent::assemble();
    }
}
