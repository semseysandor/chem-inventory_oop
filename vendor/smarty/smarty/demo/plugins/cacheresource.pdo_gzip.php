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

require_once 'cacheresource.pdo.php';

/**
 * PDO Cache Handler with GZIP support
 * Example usage :
 *      $cnx    =   new PDO("mysql:host=localhost;dbname=mydb", "username", "password");
 *      $smarty->setCachingType('pdo_gzip');
 *      $smarty->loadPlugin('Smarty_CacheResource_Pdo_Gzip');
 *      $smarty->registerCacheResource('pdo_gzip', new Smarty_CacheResource_Pdo_Gzip($cnx, 'smarty_cache'));
 *
 * @require Smarty_CacheResource_Pdo class
 * @author  Beno!t POLASZEK - 2014
 */
class Smarty_CacheResource_Pdo_Gzip extends Smarty_CacheResource_Pdo
{
    /**
     * Encodes the content before saving to database
     *
     * @param string $content
     *
     * @return string $content
     * @access protected
     */
    protected function inputContent($content)
    {
        return gzdeflate($content);
    }

    /**
     * Decodes the content before saving to database
     *
     * @param string $content
     *
     * @return string $content
     * @access protected
     */
    protected function outputContent($content)
    {
        return gzinflate($content);
    }
}
