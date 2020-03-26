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
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsModifierCompiler
 */
/**
 * Smarty wordwrap modifier plugin
 * Type:     modifier
 * Name:     wordwrap
 * Purpose:  wrap a string of text at a given length
 *
 * @link   http://smarty.php.net/manual/en/language.modifier.wordwrap.php wordwrap (Smarty online manual)
 * @author Uwe Tews
 *
 * @param array                                 $params parameters
 * @param \Smarty_Internal_TemplateCompilerBase $compiler
 *
 * @return string with compiled code
 * @throws \SmartyException
 */
function smarty_modifiercompiler_wordwrap($params, Smarty_Internal_TemplateCompilerBase $compiler)
{
    if (!isset($params[ 1 ])) {
        $params[ 1 ] = 80;
    }
    if (!isset($params[ 2 ])) {
        $params[ 2 ] = '"\n"';
    }
    if (!isset($params[ 3 ])) {
        $params[ 3 ] = 'false';
    }
    $function = 'wordwrap';
    if (Smarty::$_MBSTRING) {
        $function = $compiler->getPlugin('mb_wordwrap', 'modifier');
    }
    return $function . '(' . $params[ 0 ] . ',' . $params[ 1 ] . ',' . $params[ 2 ] . ',' . $params[ 3 ] . ')';
}
