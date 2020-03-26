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
namespace SebastianBergmann\GlobalState;

/**
 * A blacklist for global state elements that should not be snapshotted.
 */
final class Blacklist
{
    /**
     * @var array
     */
    private $globalVariables = [];

    /**
     * @var string[]
     */
    private $classes = [];

    /**
     * @var string[]
     */
    private $classNamePrefixes = [];

    /**
     * @var string[]
     */
    private $parentClasses = [];

    /**
     * @var string[]
     */
    private $interfaces = [];

    /**
     * @var array
     */
    private $staticAttributes = [];

    public function addGlobalVariable(string $variableName): void
    {
        $this->globalVariables[$variableName] = true;
    }

    public function addClass(string $className): void
    {
        $this->classes[] = $className;
    }

    public function addSubclassesOf(string $className): void
    {
        $this->parentClasses[] = $className;
    }

    public function addImplementorsOf(string $interfaceName): void
    {
        $this->interfaces[] = $interfaceName;
    }

    public function addClassNamePrefix(string $classNamePrefix): void
    {
        $this->classNamePrefixes[] = $classNamePrefix;
    }

    public function addStaticAttribute(string $className, string $attributeName): void
    {
        if (!isset($this->staticAttributes[$className])) {
            $this->staticAttributes[$className] = [];
        }

        $this->staticAttributes[$className][$attributeName] = true;
    }

    public function isGlobalVariableBlacklisted(string $variableName): bool
    {
        return isset($this->globalVariables[$variableName]);
    }

    public function isStaticAttributeBlacklisted(string $className, string $attributeName): bool
    {
        if (\in_array($className, $this->classes)) {
            return true;
        }

        foreach ($this->classNamePrefixes as $prefix) {
            if (\strpos($className, $prefix) === 0) {
                return true;
            }
        }

        $class = new \ReflectionClass($className);

        foreach ($this->parentClasses as $type) {
            if ($class->isSubclassOf($type)) {
                return true;
            }
        }

        foreach ($this->interfaces as $type) {
            if ($class->implementsInterface($type)) {
                return true;
            }
        }

        if (isset($this->staticAttributes[$className][$attributeName])) {
            return true;
        }

        return false;
    }
}
