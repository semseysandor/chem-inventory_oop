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
 * Smarty Method AppendByRef
 *
 * Smarty::appendByRef() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_AppendByRef
{
    /**
     * appends values to template variables by reference
     *
     * @api  Smarty::appendByRef()
     * @link http://www.smarty.net/docs/en/api.append.by.ref.tpl
     *
     * @param \Smarty_Internal_Data|\Smarty_Internal_Template|\Smarty $data
     * @param string                                                  $tpl_var the template variable name
     * @param mixed                                                   &$value  the referenced value to append
     * @param bool                                                    $merge   flag if array elements shall be merged
     *
     * @return \Smarty_Internal_Data|\Smarty_Internal_Template|\Smarty
     */
    public static function appendByRef(Smarty_Internal_Data $data, $tpl_var, &$value, $merge = false)
    {
        if ($tpl_var !== '' && isset($value)) {
            if (!isset($data->tpl_vars[ $tpl_var ])) {
                $data->tpl_vars[ $tpl_var ] = new Smarty_Variable();
            }
            if (!is_array($data->tpl_vars[ $tpl_var ]->value)) {
                settype($data->tpl_vars[ $tpl_var ]->value, 'array');
            }
            if ($merge && is_array($value)) {
                foreach ($value as $_key => $_val) {
                    $data->tpl_vars[ $tpl_var ]->value[ $_key ] = &$value[ $_key ];
                }
            } else {
                $data->tpl_vars[ $tpl_var ]->value[] = &$value;
            }
            if ($data->_isTplObj() && $data->scope) {
                $data->ext->_updateScope->_updateScope($data, $tpl_var);
            }
        }
        return $data;
    }
}
