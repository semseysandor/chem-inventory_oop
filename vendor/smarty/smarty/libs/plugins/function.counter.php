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
 * @subpackage PluginsFunction
 */
/**
 * Smarty {counter} function plugin
 * Type:     function
 * Name:     counter
 * Purpose:  print out a counter value
 *
 * @author Monte Ohrt <monte at ohrt dot com>
 * @link   http://www.smarty.net/manual/en/language.function.counter.php {counter}
 *         (Smarty online manual)
 *
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 *
 * @return string|null
 */
function smarty_function_counter($params, $template)
{
    static $counters = array();
    $name = (isset($params[ 'name' ])) ? $params[ 'name' ] : 'default';
    if (!isset($counters[ $name ])) {
        $counters[ $name ] = array('start' => 1, 'skip' => 1, 'direction' => 'up', 'count' => 1);
    }
    $counter =& $counters[ $name ];
    if (isset($params[ 'start' ])) {
        $counter[ 'start' ] = $counter[ 'count' ] = (int)$params[ 'start' ];
    }
    if (!empty($params[ 'assign' ])) {
        $counter[ 'assign' ] = $params[ 'assign' ];
    }
    if (isset($counter[ 'assign' ])) {
        $template->assign($counter[ 'assign' ], $counter[ 'count' ]);
    }
    if (isset($params[ 'print' ])) {
        $print = (bool)$params[ 'print' ];
    } else {
        $print = empty($counter[ 'assign' ]);
    }
    if ($print) {
        $retval = $counter[ 'count' ];
    } else {
        $retval = null;
    }
    if (isset($params[ 'skip' ])) {
        $counter[ 'skip' ] = $params[ 'skip' ];
    }
    if (isset($params[ 'direction' ])) {
        $counter[ 'direction' ] = $params[ 'direction' ];
    }
    if ($counter[ 'direction' ] === 'down') {
        $counter[ 'count' ] -= $counter[ 'skip' ];
    } else {
        $counter[ 'count' ] += $counter[ 'skip' ];
    }
    return $retval;
}
