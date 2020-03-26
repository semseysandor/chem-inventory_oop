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
 * Double quoted string inside a tag.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */

/**
 * Double quoted string inside a tag.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
class Smarty_Internal_ParseTree_Dq extends Smarty_Internal_ParseTree
{
    /**
     * Create parse tree buffer for double quoted string subtrees
     *
     * @param object                    $parser  parser object
     * @param Smarty_Internal_ParseTree $subtree parse tree buffer
     */
    public function __construct($parser, Smarty_Internal_ParseTree $subtree)
    {
        $this->subtrees[] = $subtree;
        if ($subtree instanceof Smarty_Internal_ParseTree_Tag) {
            $parser->block_nesting_level = count($parser->compiler->_tag_stack);
        }
    }

    /**
     * Append buffer to subtree
     *
     * @param \Smarty_Internal_Templateparser $parser
     * @param Smarty_Internal_ParseTree       $subtree parse tree buffer
     */
    public function append_subtree(Smarty_Internal_Templateparser $parser, Smarty_Internal_ParseTree $subtree)
    {
        $last_subtree = count($this->subtrees) - 1;
        if ($last_subtree >= 0 && $this->subtrees[ $last_subtree ] instanceof Smarty_Internal_ParseTree_Tag
            && $this->subtrees[ $last_subtree ]->saved_block_nesting < $parser->block_nesting_level
        ) {
            if ($subtree instanceof Smarty_Internal_ParseTree_Code) {
                $this->subtrees[ $last_subtree ]->data =
                    $parser->compiler->appendCode(
                        $this->subtrees[ $last_subtree ]->data,
                        '<?php echo ' . $subtree->data . ';?>'
                    );
            } elseif ($subtree instanceof Smarty_Internal_ParseTree_DqContent) {
                $this->subtrees[ $last_subtree ]->data =
                    $parser->compiler->appendCode(
                        $this->subtrees[ $last_subtree ]->data,
                        '<?php echo "' . $subtree->data . '";?>'
                    );
            } else {
                $this->subtrees[ $last_subtree ]->data =
                    $parser->compiler->appendCode($this->subtrees[ $last_subtree ]->data, $subtree->data);
            }
        } else {
            $this->subtrees[] = $subtree;
        }
        if ($subtree instanceof Smarty_Internal_ParseTree_Tag) {
            $parser->block_nesting_level = count($parser->compiler->_tag_stack);
        }
    }

    /**
     * Merge subtree buffer content together
     *
     * @param \Smarty_Internal_Templateparser $parser
     *
     * @return string compiled template code
     */
    public function to_smarty_php(Smarty_Internal_Templateparser $parser)
    {
        $code = '';
        foreach ($this->subtrees as $subtree) {
            if ($code !== '') {
                $code .= '.';
            }
            if ($subtree instanceof Smarty_Internal_ParseTree_Tag) {
                $more_php = $subtree->assign_to_var($parser);
            } else {
                $more_php = $subtree->to_smarty_php($parser);
            }
            $code .= $more_php;
            if (!$subtree instanceof Smarty_Internal_ParseTree_DqContent) {
                $parser->compiler->has_variable_string = true;
            }
        }
        return $code;
    }
}
