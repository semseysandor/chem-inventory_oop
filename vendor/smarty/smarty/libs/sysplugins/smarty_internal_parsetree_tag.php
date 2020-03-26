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
 * Smarty Internal Plugin Templateparser Parse Tree
 * These are classes to build parse tree in the template parser
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Thue Kristensen
 * @author     Uwe Tews
 */

/**
 * A complete smarty tag.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
class Smarty_Internal_ParseTree_Tag extends Smarty_Internal_ParseTree
{
    /**
     * Saved block nesting level
     *
     * @var int
     */
    public $saved_block_nesting;

    /**
     * Create parse tree buffer for Smarty tag
     *
     * @param \Smarty_Internal_Templateparser $parser parser object
     * @param string                          $data   content
     */
    public function __construct(Smarty_Internal_Templateparser $parser, $data)
    {
        $this->data = $data;
        $this->saved_block_nesting = $parser->block_nesting_level;
    }

    /**
     * Return buffer content
     *
     * @param \Smarty_Internal_Templateparser $parser
     *
     * @return string content
     */
    public function to_smarty_php(Smarty_Internal_Templateparser $parser)
    {
        return $this->data;
    }

    /**
     * Return complied code that loads the evaluated output of buffer content into a temporary variable
     *
     * @param \Smarty_Internal_Templateparser $parser
     *
     * @return string template code
     */
    public function assign_to_var(Smarty_Internal_Templateparser $parser)
    {
        $var = $parser->compiler->getNewPrefixVariable();
        $tmp = $parser->compiler->appendCode('<?php ob_start();?>', $this->data);
        $tmp = $parser->compiler->appendCode($tmp, "<?php {$var}=ob_get_clean();?>");
        $parser->compiler->prefix_code[] = sprintf('%s', $tmp);
        return $var;
    }
}
