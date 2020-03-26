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

namespace Prophecy\Doubler\Generator;

use Prophecy\Exception\Doubler\ClassCreatorException;

/**
 * Class creator.
 * Creates specific class in current environment.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class ClassCreator
{
    private $generator;

    /**
     * Initializes creator.
     *
     * @param ClassCodeGenerator $generator
     */
    public function __construct(ClassCodeGenerator $generator = null)
    {
        $this->generator = $generator ?: new ClassCodeGenerator;
    }

    /**
     * Creates class.
     *
     * @param string         $classname
     * @param Node\ClassNode $class
     *
     * @return mixed
     *
     * @throws \Prophecy\Exception\Doubler\ClassCreatorException
     */
    public function create($classname, Node\ClassNode $class)
    {
        $code = $this->generator->generate($classname, $class);
        $return = eval($code);

        if (!class_exists($classname, false)) {
            if (count($class->getInterfaces())) {
                throw new ClassCreatorException(sprintf(
                    'Could not double `%s` and implement interfaces: [%s].',
                    $class->getParentClass(), implode(', ', $class->getInterfaces())
                ), $class);
            }

            throw new ClassCreatorException(
                sprintf('Could not double `%s`.', $class->getParentClass()),
                $class
            );
        }

        return $return;
    }
}
