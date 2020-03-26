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
 * Smarty Method UnregisterFilter
 *
 * Smarty::unregisterFilter() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_UnregisterFilter extends Smarty_Internal_Method_RegisterFilter
{
    /**
     * Unregisters a filter function
     *
     * @api  Smarty::unregisterFilter()
     *
     * @link http://www.smarty.net/docs/en/api.unregister.filter.tpl
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param string                                                          $type filter type
     * @param callback|string                                                 $callback
     *
     * @return \Smarty|\Smarty_Internal_Template
     * @throws \SmartyException
     */
    public function unregisterFilter(Smarty_Internal_TemplateBase $obj, $type, $callback)
    {
        $smarty = $obj->_getSmartyObj();
        $this->_checkFilterType($type);
        if (isset($smarty->registered_filters[ $type ])) {
            $name = is_string($callback) ? $callback : $this->_getFilterName($callback);
            if (isset($smarty->registered_filters[ $type ][ $name ])) {
                unset($smarty->registered_filters[ $type ][ $name ]);
                if (empty($smarty->registered_filters[ $type ])) {
                    unset($smarty->registered_filters[ $type ]);
                }
            }
        }
        return $obj;
    }
}
