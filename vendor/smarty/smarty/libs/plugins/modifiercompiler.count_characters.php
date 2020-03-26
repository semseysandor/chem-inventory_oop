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
 * Smarty count_characters modifier plugin
 * Type:     modifier
 * Name:     count_characters
 * Purpose:  count the number of characters in a text
 *
 * @link   http://www.smarty.net/manual/en/language.modifier.count.characters.php count_characters (Smarty online
 *         manual)
 * @author Uwe Tews
 *
 * @param array $params parameters
 *
 * @return string with compiled code
 */
function smarty_modifiercompiler_count_characters($params)
{
    if (!isset($params[ 1 ]) || $params[ 1 ] !== 'true') {
        return 'preg_match_all(\'/[^\s]/' . Smarty::$_UTF8_MODIFIER . '\',' . $params[ 0 ] . ', $tmp)';
    }
    if (Smarty::$_MBSTRING) {
        return 'mb_strlen(' . $params[ 0 ] . ', \'' . addslashes(Smarty::$_CHARSET) . '\')';
    }
    // no MBString fallback
    return 'strlen(' . $params[ 0 ] . ')';
}
