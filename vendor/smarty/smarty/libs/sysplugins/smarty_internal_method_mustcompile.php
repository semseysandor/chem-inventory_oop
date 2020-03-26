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
 * Smarty Method MustCompile
 *
 * Smarty_Internal_Template::mustCompile() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_MustCompile
{
    /**
     * Valid for template object
     *
     * @var int
     */
    public $objMap = 2;

    /**
     * Returns if the current template must be compiled by the Smarty compiler
     * It does compare the timestamps of template source and the compiled templates and checks the force compile
     * configuration
     *
     * @param \Smarty_Internal_Template $_template
     *
     * @return bool
     * @throws \SmartyException
     */
    public function mustCompile(Smarty_Internal_Template $_template)
    {
        if (!$_template->source->exists) {
            if ($_template->_isSubTpl()) {
                $parent_resource = " in '$_template->parent->template_resource}'";
            } else {
                $parent_resource = '';
            }
            throw new SmartyException("Unable to load template {$_template->source->type} '{$_template->source->name}'{$parent_resource}");
        }
        if ($_template->mustCompile === null) {
            $_template->mustCompile = (!$_template->source->handler->uncompiled &&
                                       ($_template->smarty->force_compile || $_template->source->handler->recompiled ||
                                        !$_template->compiled->exists || ($_template->compile_check &&
                                                                          $_template->compiled->getTimeStamp() <
                                                                          $_template->source->getTimeStamp())));
        }
        return $_template->mustCompile;
    }
}
