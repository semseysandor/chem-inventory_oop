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
 * Smarty Internal Plugin Compile Registered Block
 * Compiles code for the execution of a registered block function
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Registered Block Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Private_Registered_Block extends Smarty_Internal_Compile_Private_Block_Plugin
{
    /**
     * Setup callback, parameter array and nocache mode
     *
     * @param \Smarty_Internal_TemplateCompilerBase $compiler
     * @param array                                 $_attr attributes
     * @param string                                $tag
     * @param null                                  $function
     *
     * @return array
     */
    public function setup(Smarty_Internal_TemplateCompilerBase $compiler, $_attr, $tag, $function)
    {
        if (isset($compiler->smarty->registered_plugins[ Smarty::PLUGIN_BLOCK ][ $tag ])) {
            $tag_info = $compiler->smarty->registered_plugins[ Smarty::PLUGIN_BLOCK ][ $tag ];
            $callback = $tag_info[ 0 ];
            if (is_array($callback)) {
                if (is_object($callback[ 0 ])) {
                    $callable = "array(\$_block_plugin{$this->nesting}, '{$callback[1]}')";
                    $callback =
                        array("\$_smarty_tpl->smarty->registered_plugins['block']['{$tag}'][0][0]", "->{$callback[1]}");
                } else {
                    $callable = "array(\$_block_plugin{$this->nesting}, '{$callback[1]}')";
                    $callback =
                        array("\$_smarty_tpl->smarty->registered_plugins['block']['{$tag}'][0][0]", "::{$callback[1]}");
                }
            } else {
                $callable = "\$_block_plugin{$this->nesting}";
                $callback = array("\$_smarty_tpl->smarty->registered_plugins['block']['{$tag}'][0]", '');
            }
        } else {
            $tag_info = $compiler->default_handler_plugins[ Smarty::PLUGIN_BLOCK ][ $tag ];
            $callback = $tag_info[ 0 ];
            if (is_array($callback)) {
                $callable = "array('{$callback[0]}', '{$callback[1]}')";
                $callback = "{$callback[1]}::{$callback[1]}";
            } else {
                $callable = null;
            }
        }
        $compiler->tag_nocache = !$tag_info[ 1 ] | $compiler->tag_nocache;
        $_paramsArray = array();
        foreach ($_attr as $_key => $_value) {
            if (is_int($_key)) {
                $_paramsArray[] = "$_key=>$_value";
            } elseif ($compiler->template->caching && in_array($_key, $tag_info[ 2 ])) {
                $_value = str_replace('\'', "^#^", $_value);
                $_paramsArray[] = "'$_key'=>^#^.var_export($_value,true).^#^";
            } else {
                $_paramsArray[] = "'$_key'=>$_value";
            }
        }
        return array($callback, $_paramsArray, $callable);
    }
}
