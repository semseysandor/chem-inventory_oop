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
 * Smarty Method GetAutoloadFilters
 *
 * Smarty::getAutoloadFilters() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_GetAutoloadFilters extends Smarty_Internal_Method_SetAutoloadFilters
{
    /**
     * Get autoload filters
     *
     * @api Smarty::getAutoloadFilters()
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param string                                                          $type type of filter to get auto loads
     *                                                                              for. Defaults to all autoload
     *                                                                              filters
     *
     * @return array array( 'type1' => array( 'filter1', 'filter2', … ) ) or array( 'filter1', 'filter2', …) if $type
     *                was specified
     * @throws \SmartyException
     */
    public function getAutoloadFilters(Smarty_Internal_TemplateBase $obj, $type = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($type !== null) {
            $this->_checkFilterType($type);
            return isset($smarty->autoload_filters[ $type ]) ? $smarty->autoload_filters[ $type ] : array();
        }
        return $smarty->autoload_filters;
    }
}
