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
 * Smarty shared plugin
 *
 * @package    Smarty
 * @subpackage PluginsShared
 */
/**
 * Function: smarty_make_timestamp
 * Purpose:  used by other smarty functions to make a timestamp from a string.
 *
 * @author Monte Ohrt <monte at ohrt dot com>
 *
 * @param DateTime|int|string $string date object, timestamp or string that can be converted using strtotime()
 *
 * @return int
 */
function smarty_make_timestamp($string)
{
    if (empty($string)) {
        // use "now":
        return time();
    } elseif ($string instanceof DateTime
              || (interface_exists('DateTimeInterface', false) && $string instanceof DateTimeInterface)
    ) {
        return (int)$string->format('U'); // PHP 5.2 BC
    } elseif (strlen($string) === 14 && ctype_digit($string)) {
        // it is mysql timestamp format of YYYYMMDDHHMMSS?
        return mktime(
            substr($string, 8, 2),
            substr($string, 10, 2),
            substr($string, 12, 2),
            substr($string, 4, 2),
            substr($string, 6, 2),
            substr($string, 0, 4)
        );
    } elseif (is_numeric($string)) {
        // it is a numeric string, we handle it as timestamp
        return (int)$string;
    } else {
        // strtotime should handle it
        $time = strtotime($string);
        if ($time === -1 || $time === false) {
            // strtotime() was not able to parse $string, use "now":
            return time();
        }
        return $time;
    }
}
