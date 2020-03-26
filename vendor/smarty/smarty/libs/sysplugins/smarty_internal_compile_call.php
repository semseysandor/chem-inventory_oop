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
 * Smarty Internal Plugin Compile Function_Call
 * Compiles the calls of user defined tags defined by {function}
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Function_Call Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Call extends Smarty_Internal_CompileBase
{
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $required_attributes = array('name');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $shorttag_order = array('name');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $optional_attributes = array('_any');

    /**
     * Compiles the calls of user defined tags defined by {function}
     *
     * @param array  $args     array with attributes from parser
     * @param object $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // save possible attributes
        if (isset($_attr[ 'assign' ])) {
            // output will be stored in a smarty variable instead of being displayed
            $_assign = $_attr[ 'assign' ];
        }
        //$_name = trim($_attr['name'], "''");
        $_name = $_attr[ 'name' ];
        unset($_attr[ 'name' ], $_attr[ 'assign' ], $_attr[ 'nocache' ]);
        // set flag (compiled code of {function} must be included in cache file
        if (!$compiler->template->caching || $compiler->nocache || $compiler->tag_nocache) {
            $_nocache = 'true';
        } else {
            $_nocache = 'false';
        }
        $_paramsArray = array();
        foreach ($_attr as $_key => $_value) {
            if (is_int($_key)) {
                $_paramsArray[] = "$_key=>$_value";
            } else {
                $_paramsArray[] = "'$_key'=>$_value";
            }
        }
        $_params = 'array(' . implode(',', $_paramsArray) . ')';
        //$compiler->suppressNocacheProcessing = true;
        // was there an assign attribute
        if (isset($_assign)) {
            $_output =
                "<?php ob_start();\n\$_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction(\$_smarty_tpl, {$_name}, {$_params}, {$_nocache});\n\$_smarty_tpl->assign({$_assign}, ob_get_clean());?>\n";
        } else {
            $_output =
                "<?php \$_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction(\$_smarty_tpl, {$_name}, {$_params}, {$_nocache});?>\n";
        }
        return $_output;
    }
}
