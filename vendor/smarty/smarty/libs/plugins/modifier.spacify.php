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
 * @subpackage PluginsModifier
 */
/**
 * Smarty spacify modifier plugin
 * Type:     modifier
 * Name:     spacify
 * Purpose:  add spaces between characters in a string
 *
 * @link   http://smarty.php.net/manual/en/language.modifier.spacify.php spacify (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 *
 * @param string $string       input string
 * @param string $spacify_char string to insert between characters.
 *
 * @return string
 */
function smarty_modifier_spacify($string, $spacify_char = ' ')
{
    // well… what about charsets besides latin and UTF-8?
    return implode($spacify_char, preg_split('//' . Smarty::$_UTF8_MODIFIER, $string, -1, PREG_SPLIT_NO_EMPTY));
}
