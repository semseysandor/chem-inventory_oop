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
 * Smarty Method GetGlobal
 *
 * Smarty::getGlobal() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_GetGlobal
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * Returns a single or all global  variables
     *
     * @api Smarty::getGlobal()
     *
     * @param \Smarty_Internal_Data $data
     * @param string                $varName variable name or null
     *
     * @return string|array variable value or or array of variables
     */
    public function getGlobal(Smarty_Internal_Data $data, $varName = null)
    {
        if (isset($varName)) {
            if (isset(Smarty::$global_tpl_vars[ $varName ])) {
                return Smarty::$global_tpl_vars[ $varName ]->value;
            } else {
                return '';
            }
        } else {
            $_result = array();
            foreach (Smarty::$global_tpl_vars as $key => $var) {
                $_result[ $key ] = $var->value;
            }
            return $_result;
        }
    }
}
