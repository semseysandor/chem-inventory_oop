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

namespace Prophecy\Doubler\ClassPatch;

use Prophecy\Doubler\Generator\Node\ClassNode;

/**
 * Exception patch for HHVM to remove the stubs from special methods
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class HhvmExceptionPatch implements ClassPatchInterface
{
    /**
     * Supports exceptions on HHVM.
     *
     * @param ClassNode $node
     *
     * @return bool
     */
    public function supports(ClassNode $node)
    {
        if (!defined('HHVM_VERSION')) {
            return false;
        }

        return 'Exception' === $node->getParentClass() || is_subclass_of($node->getParentClass(), 'Exception');
    }

    /**
     * Removes special exception static methods from the doubled methods.
     *
     * @param ClassNode $node
     *
     * @return void
     */
    public function apply(ClassNode $node)
    {
        if ($node->hasMethod('setTraceOptions')) {
            $node->getMethod('setTraceOptions')->useParentCode();
        }
        if ($node->hasMethod('getTraceOptions')) {
            $node->getMethod('getTraceOptions')->useParentCode();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return -50;
    }
}
