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
 * Smarty unescape modifier plugin
 * Type:     modifier
 * Name:     unescape
 * Purpose:  unescape html entities
 *
 * @author Rodney Rehm
 *
 * @param array $params parameters
 *
 * @return string with compiled code
 */
function smarty_modifiercompiler_unescape($params)
{
    if (!isset($params[ 1 ])) {
        $params[ 1 ] = 'html';
    }
    if (!isset($params[ 2 ])) {
        $params[ 2 ] = '\'' . addslashes(Smarty::$_CHARSET) . '\'';
    } else {
        $params[ 2 ] = "'{$params[ 2 ]}'";
    }
    switch (trim($params[ 1 ], '"\'')) {
        case 'entity':
        case 'htmlall':
            if (Smarty::$_MBSTRING) {
                return 'mb_convert_encoding(' . $params[ 0 ] . ', ' . $params[ 2 ] . ', \'HTML-ENTITIES\')';
            }
            return 'html_entity_decode(' . $params[ 0 ] . ', ENT_NOQUOTES, ' . $params[ 2 ] . ')';
        case 'html':
            return 'htmlspecialchars_decode(' . $params[ 0 ] . ', ENT_QUOTES)';
        case 'url':
            return 'rawurldecode(' . $params[ 0 ] . ')';
        default:
            return $params[ 0 ];
    }
}
