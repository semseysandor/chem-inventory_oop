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
 * APC CacheResource
 * CacheResource Implementation based on the KeyValueStore API to use
 * memcache as the storage resource for Smarty's output caching.
 * *
 *
 * @package CacheResource-examples
 * @author  Uwe Tews
 */
class Smarty_CacheResource_Apc extends Smarty_CacheResource_KeyValueStore
{
    /**
     * Smarty_CacheResource_Apc constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        // test if APC is present
        if (!function_exists('apc_cache_info')) {
            throw new Exception('APC Template Caching Error: APC is not installed');
        }
    }

    /**
     * Read values for a set of keys from cache
     *
     * @param array $keys list of keys to fetch
     *
     * @return array   list of values with the given keys used as indexes
     * @return boolean true on success, false on failure
     */
    protected function read(array $keys)
    {
        $_res = array();
        $res = apc_fetch($keys);
        foreach ($res as $k => $v) {
            $_res[ $k ] = $v;
        }
        return $_res;
    }

    /**
     * Save values for a set of keys to cache
     *
     * @param array $keys   list of values to save
     * @param int   $expire expiration time
     *
     * @return boolean true on success, false on failure
     */
    protected function write(array $keys, $expire = null)
    {
        foreach ($keys as $k => $v) {
            apc_store($k, $v, $expire);
        }
        return true;
    }

    /**
     * Remove values from cache
     *
     * @param array $keys list of keys to delete
     *
     * @return boolean true on success, false on failure
     */
    protected function delete(array $keys)
    {
        foreach ($keys as $k) {
            apc_delete($k);
        }
        return true;
    }

    /**
     * Remove *all* values from cache
     *
     * @return boolean true on success, false on failure
     */
    protected function purge()
    {
        return apc_clear_cache('user');
    }
}
