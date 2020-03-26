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

namespace Prophecy\PhpDocumentor;

use phpDocumentor\Reflection\DocBlock\Tag\MethodTag as LegacyMethodTag;
use phpDocumentor\Reflection\DocBlock\Tags\Method;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 *
 * @internal
 */
final class ClassAndInterfaceTagRetriever implements MethodTagRetrieverInterface
{
    private $classRetriever;

    public function __construct(MethodTagRetrieverInterface $classRetriever = null)
    {
        if (null !== $classRetriever) {
            $this->classRetriever = $classRetriever;

            return;
        }

        $this->classRetriever = class_exists('phpDocumentor\Reflection\DocBlockFactory') && class_exists('phpDocumentor\Reflection\Types\ContextFactory')
            ? new ClassTagRetriever()
            : new LegacyClassTagRetriever()
        ;
    }

    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return LegacyMethodTag[]|Method[]
     */
    public function getTagList(\ReflectionClass $reflectionClass)
    {
        return array_merge(
            $this->classRetriever->getTagList($reflectionClass),
            $this->getInterfacesTagList($reflectionClass)
        );
    }

    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return LegacyMethodTag[]|Method[]
     */
    private function getInterfacesTagList(\ReflectionClass $reflectionClass)
    {
        $interfaces = $reflectionClass->getInterfaces();
        $tagList = array();

        foreach($interfaces as $interface) {
            $tagList = array_merge($tagList, $this->classRetriever->getTagList($interface));
        }

        return $tagList;
    }
}
