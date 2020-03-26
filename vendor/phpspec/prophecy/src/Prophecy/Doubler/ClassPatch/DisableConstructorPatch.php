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
use Prophecy\Doubler\Generator\Node\MethodNode;

/**
 * Disable constructor.
 * Makes all constructor arguments optional.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class DisableConstructorPatch implements ClassPatchInterface
{
    /**
     * Checks if class has `__construct` method.
     *
     * @param ClassNode $node
     *
     * @return bool
     */
    public function supports(ClassNode $node)
    {
        return true;
    }

    /**
     * Makes all class constructor arguments optional.
     *
     * @param ClassNode $node
     */
    public function apply(ClassNode $node)
    {
        if (!$node->isExtendable('__construct')) {
            return;
        }

        if (!$node->hasMethod('__construct')) {
            $node->addMethod(new MethodNode('__construct', ''));

            return;
        }

        $constructor = $node->getMethod('__construct');
        foreach ($constructor->getArguments() as $argument) {
            $argument->setDefault(null);
        }

        $constructor->setCode(<<<PHP
if (0 < func_num_args()) {
    call_user_func_array(array('parent', '__construct'), func_get_args());
}
PHP
        );
    }

    /**
     * Returns patch priority, which determines when patch will be applied.
     *
     * @return int Priority number (higher - earlier)
     */
    public function getPriority()
    {
        return 100;
    }
}
