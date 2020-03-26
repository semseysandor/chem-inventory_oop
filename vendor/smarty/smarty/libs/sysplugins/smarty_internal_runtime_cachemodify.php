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
 * Inline Runtime Methods render, setSourceByUid, setupSubTemplate
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 **/
class Smarty_Internal_Runtime_CacheModify
{
    /**
     * check client side cache
     *
     * @param \Smarty_Template_Cached   $cached
     * @param \Smarty_Internal_Template $_template
     * @param string                    $content
     *
     * @throws \Exception
     * @throws \SmartyException
     */
    public function cacheModifiedCheck(Smarty_Template_Cached $cached, Smarty_Internal_Template $_template, $content)
    {
        $_isCached = $_template->isCached() && !$_template->compiled->has_nocache_code;
        $_last_modified_date =
            @substr($_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ], 0, strpos($_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ], 'GMT') + 3);
        if ($_isCached && $cached->timestamp <= strtotime($_last_modified_date)) {
            switch (PHP_SAPI) {
                case 'cgi': // php-cgi < 5.3
                case 'cgi-fcgi': // php-cgi >= 5.3
                case 'fpm-fcgi': // php-fpm >= 5.3.3
                    header('Status: 304 Not Modified');
                    break;
                case 'cli':
                    if (/* ^phpunit */
                    !empty($_SERVER[ 'SMARTY_PHPUNIT_DISABLE_HEADERS' ]) /* phpunit$ */
                    ) {
                        $_SERVER[ 'SMARTY_PHPUNIT_HEADERS' ][] = '304 Not Modified';
                    }
                    break;
                default:
                    if (/* ^phpunit */
                    !empty($_SERVER[ 'SMARTY_PHPUNIT_DISABLE_HEADERS' ]) /* phpunit$ */
                    ) {
                        $_SERVER[ 'SMARTY_PHPUNIT_HEADERS' ][] = '304 Not Modified';
                    } else {
                        header($_SERVER[ 'SERVER_PROTOCOL' ] . ' 304 Not Modified');
                    }
                    break;
            }
        } else {
            switch (PHP_SAPI) {
                case 'cli':
                    if (/* ^phpunit */
                    !empty($_SERVER[ 'SMARTY_PHPUNIT_DISABLE_HEADERS' ]) /* phpunit$ */
                    ) {
                        $_SERVER[ 'SMARTY_PHPUNIT_HEADERS' ][] =
                            'Last-Modified: ' . gmdate('D, d M Y H:i:s', $cached->timestamp) . ' GMT';
                    }
                    break;
                default:
                    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $cached->timestamp) . ' GMT');
                    break;
            }
            echo $content;
        }
    }
}
