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
 * Smarty Resource Plugin
 *
 * @package    Smarty
 * @subpackage TemplateResources
 * @author     Rodney Rehm
 */

/**
 * Smarty Resource Plugin
 * Base implementation for resource plugins that don't use the compiler
 *
 * @package    Smarty
 * @subpackage TemplateResources
 */
abstract class Smarty_Resource_Uncompiled extends Smarty_Resource
{
    /**
     * Flag that it's an uncompiled resource
     *
     * @var bool
     */
    public $uncompiled = true;

    /**
     * Resource does implement populateCompiledFilepath() method
     *
     * @var bool
     */
    public $hasCompiledHandler = true;

    /**
     * populate compiled object with compiled filepath
     *
     * @param Smarty_Template_Compiled $compiled  compiled object
     * @param Smarty_Internal_Template $_template template object
     */
    public function populateCompiledFilepath(Smarty_Template_Compiled $compiled, Smarty_Internal_Template $_template)
    {
        $compiled->filepath = $_template->source->filepath;
        $compiled->timestamp = $_template->source->timestamp;
        $compiled->exists = $_template->source->exists;
        if ($_template->smarty->merge_compiled_includes || $_template->source->handler->checkTimestamps()) {
            $compiled->file_dependency[ $_template->source->uid ] =
                array($compiled->filepath, $compiled->timestamp, $_template->source->type,);
        }
    }
}
