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
 * Smarty Method SetAutoloadFilters
 *
 * Smarty::setAutoloadFilters() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_SetAutoloadFilters
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Valid filter types
     *
     * @var array
     */
    private $filterTypes = array('pre' => true, 'post' => true, 'output' => true, 'variable' => true);

    /**
     * Set autoload filters
     *
     * @api Smarty::setAutoloadFilters()
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param array                                                           $filters filters to load automatically
     * @param string                                                          $type    "pre", "output", … specify
     *                                                                                 the filter type to set.
     *                                                                                 Defaults to none treating
     *                                                                                 $filters' keys as the
     *                                                                                 appropriate types
     *
     * @return \Smarty|\Smarty_Internal_Template
     * @throws \SmartyException
     */
    public function setAutoloadFilters(Smarty_Internal_TemplateBase $obj, $filters, $type = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($type !== null) {
            $this->_checkFilterType($type);
            $smarty->autoload_filters[ $type ] = (array)$filters;
        } else {
            foreach ((array)$filters as $type => $value) {
                $this->_checkFilterType($type);
            }
            $smarty->autoload_filters = (array)$filters;
        }
        return $obj;
    }

    /**
     * Check if filter type is valid
     *
     * @param string $type
     *
     * @throws \SmartyException
     */
    public function _checkFilterType($type)
    {
        if (!isset($this->filterTypes[ $type ])) {
            throw new SmartyException("Illegal filter type '{$type}'");
        }
    }
}
