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
use Inventory\Core\Exception\InventoryException;

class Index
{
    private $template;

    public function build()
    {
        $this->preProcess();

        $this->process();

        $this->assemble();

        return $this->template;
    }

    public function preProcess()
    {
    }

    public function process()
    {
        try {
            $bao = new Compound();
            $this->assignVar('compounds', $bao->getAll());

            echo "majom\n";
            echo ts("maki\n");
            echo ts('manki %s %s', 'veba', 'repa')."\n";

            if (empty($majom)) {
                echo "ures";
            } else {
                echo "teli";
            }
        } catch (InventoryException $ex) {
            echo $ex->getMessage().' '.$ex->getContext();
            exit;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        } catch (Error $ex) {
            echo $ex->getMessage();
        } finally {
            exit;
        }
    }

    public function assemble()
    {
        $this->template['template'] = str_replace('\\', '/', __CLASS__).'.tpl';

        $this->assignVar('majom', 'beco');
        $this->assignVar('kutya', ['maki', 'lali', 'papi']);
    }

    protected function assignVar($name, $value)
    {
        $this->template['vars'][$name] = $value;
    }
}
