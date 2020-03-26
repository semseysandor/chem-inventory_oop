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
 * convert characters to their decimal unicode equivalents
 *
 * @link   http://www.ibm.com/developerworks/library/os-php-unicode/index.html#listing3 for inspiration
 *
 * @param string $string   characters to calculate unicode of
 * @param string $encoding encoding of $string, if null mb_internal_encoding() is used
 *
 * @return array sequence of unicodes
 * @author Rodney Rehm
 */
function smarty_mb_to_unicode($string, $encoding = null)
{
    if ($encoding) {
        $expanded = mb_convert_encoding($string, 'UTF-32BE', $encoding);
    } else {
        $expanded = mb_convert_encoding($string, 'UTF-32BE');
    }
    return unpack('N*', $expanded);
}

/**
 * convert unicodes to the character of given encoding
 *
 * @link   http://www.ibm.com/developerworks/library/os-php-unicode/index.html#listing3 for inspiration
 *
 * @param integer|array $unicode  single unicode or list of unicodes to convert
 * @param string        $encoding encoding of returned string, if null mb_internal_encoding() is used
 *
 * @return string unicode as character sequence in given $encoding
 * @author Rodney Rehm
 */
function smarty_mb_from_unicode($unicode, $encoding = null)
{
    $t = '';
    if (!$encoding) {
        $encoding = mb_internal_encoding();
    }
    foreach ((array)$unicode as $utf32be) {
        $character = pack('N*', $utf32be);
        $t .= mb_convert_encoding($character, $encoding, 'UTF-32BE');
    }
    return $t;
}
