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
 * Smarty {block} tag class
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Block
{
    /**
     * Block name
     *
     * @var string
     */
    public $name = '';

    /**
     * Hide attribute
     *
     * @var bool
     */
    public $hide = false;

    /**
     * Append attribute
     *
     * @var bool
     */
    public $append = false;

    /**
     * prepend attribute
     *
     * @var bool
     */
    public $prepend = false;

    /**
     * Block calls $smarty.block.child
     *
     * @var bool
     */
    public $callsChild = false;

    /**
     * Inheritance child block
     *
     * @var Smarty_Internal_Block|null
     */
    public $child = null;

    /**
     * Inheritance calling parent block
     *
     * @var Smarty_Internal_Block|null
     */
    public $parent = null;

    /**
     * Inheritance Template index
     *
     * @var int
     */
    public $tplIndex = 0;

    /**
     * Smarty_Internal_Block constructor.
     * - if outer level {block} of child template ($state === 1) save it as child root block
     * - otherwise process inheritance and render
     *
     * @param string   $name     block name
     * @param int|null $tplIndex index of outer level {block} if nested
     */
    public function __construct($name, $tplIndex)
    {
        $this->name = $name;
        $this->tplIndex = $tplIndex;
    }

    /**
     * Compiled block code overloaded by {block} class
     *
     * @param \Smarty_Internal_Template $tpl
     */
    public function callBlock(Smarty_Internal_Template $tpl)
    {
    }
}
