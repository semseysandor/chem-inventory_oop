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
 * Smarty Method GetConfigVars
 *
 * Smarty::getConfigVars() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_GetConfigVars
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * Returns a single or all config variables
     *
     * @api  Smarty::getConfigVars()
     * @link http://www.smarty.net/docs/en/api.get.config.vars.tpl
     *
     * @param \Smarty_Internal_Data|\Smarty_Internal_Template|\Smarty $data
     * @param string                                                  $varname        variable name or null
     * @param bool                                                    $search_parents include parent templates?
     *
     * @return mixed variable value or or array of variables
     */
    public function getConfigVars(Smarty_Internal_Data $data, $varname = null, $search_parents = true)
    {
        $_ptr = $data;
        $var_array = array();
        while ($_ptr !== null) {
            if (isset($varname)) {
                if (isset($_ptr->config_vars[ $varname ])) {
                    return $_ptr->config_vars[ $varname ];
                }
            } else {
                $var_array = array_merge($_ptr->config_vars, $var_array);
            }
            // not found, try at parent
            if ($search_parents) {
                $_ptr = $_ptr->parent;
            } else {
                $_ptr = null;
            }
        }
        if (isset($varname)) {
            return '';
        } else {
            return $var_array;
        }
    }
}
