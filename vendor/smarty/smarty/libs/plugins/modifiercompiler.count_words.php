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
 * Smarty count_words modifier plugin
 * Type:     modifier
 * Name:     count_words
 * Purpose:  count the number of words in a text
 *
 * @link   http://www.smarty.net/manual/en/language.modifier.count.words.php count_words (Smarty online manual)
 * @author Uwe Tews
 *
 * @param array $params parameters
 *
 * @return string with compiled code
 */
function smarty_modifiercompiler_count_words($params)
{
    if (Smarty::$_MBSTRING) {
        // return 'preg_match_all(\'#[\w\pL]+#' . Smarty::$_UTF8_MODIFIER . '\', ' . $params[0] . ', $tmp)';
        // expression taken from http://de.php.net/manual/en/function.str-word-count.php#85592
        return 'preg_match_all(\'/\p{L}[\p{L}\p{Mn}\p{Pd}\\\'\x{2019}]*/' . Smarty::$_UTF8_MODIFIER . '\', ' .
               $params[ 0 ] . ', $tmp)';
    }
    // no MBString fallback
    return 'str_word_count(' . $params[ 0 ] . ')';
}
