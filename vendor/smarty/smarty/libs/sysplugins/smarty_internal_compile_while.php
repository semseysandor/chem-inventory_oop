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
 * Smarty Internal Plugin Compile While
 * Compiles the {while} tag
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile While Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_While extends Smarty_Internal_CompileBase
{
    /**
     * Compiles code for the {while} tag
     *
     * @param array                                 $args      array with attributes from parser
     * @param \Smarty_Internal_TemplateCompilerBase $compiler  compiler object
     * @param array                                 $parameter array with compilation parameter
     *
     * @return string compiled code
     * @throws \SmartyCompilerException
     */
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter)
    {
        $compiler->loopNesting++;
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        $this->openTag($compiler, 'while', $compiler->nocache);
        if (!array_key_exists('if condition', $parameter)) {
            $compiler->trigger_template_error('missing while condition', null, true);
        }
        // maybe nocache because of nocache variables
        $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;
        if (is_array($parameter[ 'if condition' ])) {
            if ($compiler->nocache) {
                // create nocache var to make it know for further compiling
                if (is_array($parameter[ 'if condition' ][ 'var' ])) {
                    $var = $parameter[ 'if condition' ][ 'var' ][ 'var' ];
                } else {
                    $var = $parameter[ 'if condition' ][ 'var' ];
                }
                $compiler->setNocacheInVariable($var);
            }
            $prefixVar = $compiler->getNewPrefixVariable();
            $assignCompiler = new Smarty_Internal_Compile_Assign();
            $assignAttr = array();
            $assignAttr[][ 'value' ] = $prefixVar;
            if (is_array($parameter[ 'if condition' ][ 'var' ])) {
                $assignAttr[][ 'var' ] = $parameter[ 'if condition' ][ 'var' ][ 'var' ];
                $_output = "<?php while ({$prefixVar} = {$parameter[ 'if condition' ][ 'value' ]}) {?>";
                $_output .= $assignCompiler->compile(
                    $assignAttr,
                    $compiler,
                    array('smarty_internal_index' => $parameter[ 'if condition' ][ 'var' ][ 'smarty_internal_index' ])
                );
            } else {
                $assignAttr[][ 'var' ] = $parameter[ 'if condition' ][ 'var' ];
                $_output = "<?php while ({$prefixVar} = {$parameter[ 'if condition' ][ 'value' ]}) {?>";
                $_output .= $assignCompiler->compile($assignAttr, $compiler, array());
            }
            return $_output;
        } else {
            return "<?php\n while ({$parameter['if condition']}) {?>";
        }
    }
}

/**
 * Smarty Internal Plugin Compile Whileclose Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Whileclose extends Smarty_Internal_CompileBase
{
    /**
     * Compiles code for the {/while} tag
     *
     * @param array                                 $args     array with attributes from parser
     * @param \Smarty_Internal_TemplateCompilerBase $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $compiler->loopNesting--;
        // must endblock be nocache?
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }
        $compiler->nocache = $this->closeTag($compiler, array('while'));
        return "<?php }?>\n";
    }
}
