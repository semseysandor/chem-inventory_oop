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
 * {make_nocache} Runtime Methods save(), store()
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Runtime_Make_Nocache
{
    /**
     * Save current variable value while rendering compiled template and inject nocache code to
     * assign variable value in cahed template
     *
     * @param \Smarty_Internal_Template $tpl
     * @param string                    $var variable name
     *
     * @throws \SmartyException
     */
    public function save(Smarty_Internal_Template $tpl, $var)
    {
        if (isset($tpl->tpl_vars[ $var ])) {
            $export =
                preg_replace('/^Smarty_Variable::__set_state[(]|[)]$/', '', var_export($tpl->tpl_vars[ $var ], true));
            if (preg_match('/(\w+)::__set_state/', $export, $match)) {
                throw new SmartyException("{make_nocache \${$var}} in template '{$tpl->source->name}': variable does contain object '{$match[1]}' not implementing method '__set_state'");
            }
            echo "/*%%SmartyNocache:{$tpl->compiled->nocache_hash}%%*/<?php " .
                 addcslashes("\$_smarty_tpl->smarty->ext->_make_nocache->store(\$_smarty_tpl, '{$var}', ", '\\') .
                 $export . ");?>\n/*/%%SmartyNocache:{$tpl->compiled->nocache_hash}%%*/";
        }
    }

    /**
     * Store variable value saved while rendering compiled template in cached template context
     *
     * @param \Smarty_Internal_Template $tpl
     * @param string                    $var variable name
     * @param array                     $properties
     */
    public function store(Smarty_Internal_Template $tpl, $var, $properties)
    {
        // do not overwrite existing nocache variables
        if (!isset($tpl->tpl_vars[ $var ]) || !$tpl->tpl_vars[ $var ]->nocache) {
            $newVar = new Smarty_Variable();
            unset($properties[ 'nocache' ]);
            foreach ($properties as $k => $v) {
                $newVar->$k = $v;
            }
            $tpl->tpl_vars[ $var ] = $newVar;
        }
    }
}
