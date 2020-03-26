<?php declare(strict_types=1);
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
namespace PHPUnit\Util\Annotation;

use PHPUnit\Util\Exception;

/**
 * Reflection information, and therefore DocBlock information, is static within
 * a single PHP process. It is therefore okay to use a Singleton registry here.
 *
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class Registry
{
    /** @var null|self */
    private static $instance;

    /** @var array<string, DocBlock> indexed by class name */
    private $classDocBlocks = [];

    /** @var array<string, array<string, DocBlock>> indexed by class name and method name */
    private $methodDocBlocks = [];

    public static function getInstance(): self
    {
        return self::$instance ?? self::$instance = new self;
    }

    private function __construct()
    {
    }

    /**
     * @throws Exception
     * @psalm-param class-string $class
     */
    public function forClassName(string $class): DocBlock
    {
        if (\array_key_exists($class, $this->classDocBlocks)) {
            return $this->classDocBlocks[$class];
        }

        try {
            $reflection = new \ReflectionClass($class);
            // @codeCoverageIgnoreStart
        } catch (\ReflectionException $e) {
            throw new Exception(
                $e->getMessage(),
                (int) $e->getCode(),
                $e
            );
        }
        // @codeCoverageIgnoreEnd

        return $this->classDocBlocks[$class] = DocBlock::ofClass($reflection);
    }

    /**
     * @throws Exception
     * @psalm-param class-string $classInHierarchy
     */
    public function forMethod(string $classInHierarchy, string $method): DocBlock
    {
        if (isset($this->methodDocBlocks[$classInHierarchy][$method])) {
            return $this->methodDocBlocks[$classInHierarchy][$method];
        }

        try {
            $reflection = new \ReflectionMethod($classInHierarchy, $method);
            // @codeCoverageIgnoreStart
        } catch (\ReflectionException $e) {
            throw new Exception(
                $e->getMessage(),
                (int) $e->getCode(),
                $e
            );
        }
        // @codeCoverageIgnoreEnd

        return $this->methodDocBlocks[$classInHierarchy][$method] = DocBlock::ofMethod($reflection, $classInHierarchy);
    }
}
