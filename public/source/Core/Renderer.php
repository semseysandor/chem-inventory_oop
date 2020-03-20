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

namespace Inventory\Core;

use Smarty;

/**
 * Renderer
 *
 * @category Render
 * @package  Inventory
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Renderer
{
    /**
     * Templates directory
     */
    private const TEMPLATE_DIR = ROOT.'/templates/';

    /**
     * Compiled templates directory
     */
    private const TEMPLATE_COMPILE_DIR = ROOT.'/cache/templates_compile/';

    /**
     * Cached templates directory
     */
    private const TEMPLATE_CACHE_DIR = ROOT.'/cache/templates_cache/';

    /**
     * Renders a template in HTML
     *
     * @param array $template Template
     *   Format:
     *   [ file => template_file,   # Template file
     *     vars => [                # Template variables
     *              var1 => value1,
     *              var2 => value2
     *             ]
     *   ]
     *
     * @throws \SmartyException
     */
    public function render(array $template)
    {
        $smarty = new Smarty();

        $smarty->setTemplateDir(self::TEMPLATE_DIR);
        $smarty->setCompileDir(self::TEMPLATE_COMPILE_DIR);
        $smarty->setCacheDir(self::TEMPLATE_CACHE_DIR);
        $smarty->clearAllCache();

        foreach ($template['vars'] as $name => $value) {
            $smarty->assign($name, $value);
        }

        foreach ($template['templates'] as $name => $value) {
            $smarty->assign('_'.$name, $value.'.tpl');
        }

        $base_template = $template['templates']['base'].'.tpl';
        $smarty->display($base_template);
    }

    /**
     * Renders a template for the console
     *
     * @param array $template
     */
    public function renderConsole(array $template)
    {
        foreach ($template['vars'] as $name => $value) {
            echo "Name : ".var_export($name, true)."\n";
            if (is_array($value)) {
                foreach ($value as $key => $item) {
                    echo "Array key: ".var_export($key, true)."\n";
                    echo "Array val: ".var_export($item, true)."\n";
                }
            } else {
                echo "Value: ".var_export($value, true)."\n";
            }
            echo "\n";
        }
    }
}
