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

/**
 * Smarty Method CreateData
 *
 * Smarty::createData() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_CreateData
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * creates a data object
     *
     * @api  Smarty::createData()
     * @link http://www.smarty.net/docs/en/api.create.data.tpl
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty      $obj
     * @param \Smarty_Internal_Template|\Smarty_Internal_Data|\Smarty_Data|\Smarty $parent next higher level of Smarty
     *                                                                                     variables
     * @param string                                                               $name   optional data block name
     *
     * @return \Smarty_Data data object
     */
    public function createData(Smarty_Internal_TemplateBase $obj, Smarty_Internal_Data $parent = null, $name = null)
    {
        /* @var Smarty $smarty */
        $smarty = $obj->_getSmartyObj();
        $dataObj = new Smarty_Data($parent, $smarty, $name);
        if ($smarty->debugging) {
            Smarty_Internal_Debug::register_data($dataObj);
        }
        return $dataObj;
    }
}
