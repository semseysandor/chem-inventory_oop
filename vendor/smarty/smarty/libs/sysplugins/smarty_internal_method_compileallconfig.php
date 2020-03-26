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
 * Smarty Method CompileAllConfig
 *
 * Smarty::compileAllConfig() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_CompileAllConfig extends Smarty_Internal_Method_CompileAllTemplates
{
    /**
     * Compile all config files
     *
     * @api Smarty::compileAllConfig()
     *
     * @param \Smarty $smarty        passed smarty object
     * @param string  $extension     file extension
     * @param bool    $force_compile force all to recompile
     * @param int     $time_limit
     * @param int     $max_errors
     *
     * @return int number of template files recompiled
     */
    public function compileAllConfig(
        Smarty $smarty,
        $extension = '.conf',
        $force_compile = false,
        $time_limit = 0,
        $max_errors = null
    ) {
        return $this->compileAll($smarty, $extension, $force_compile, $time_limit, $max_errors, true);
    }
}
