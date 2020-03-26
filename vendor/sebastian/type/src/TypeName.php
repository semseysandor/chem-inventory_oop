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
namespace SebastianBergmann\Type;

final class TypeName
{
    /**
     * @var ?string
     */
    private $namespaceName;

    /**
     * @var string
     */
    private $simpleName;

    public static function fromQualifiedName(string $fullClassName): self
    {
        if ($fullClassName[0] === '\\') {
            $fullClassName = \substr($fullClassName, 1);
        }

        $classNameParts = \explode('\\', $fullClassName);

        $simpleName    = \array_pop($classNameParts);
        $namespaceName = \implode('\\', $classNameParts);

        return new self($namespaceName, $simpleName);
    }

    public static function fromReflection(\ReflectionClass $type): self
    {
        return new self(
            $type->getNamespaceName(),
            $type->getShortName()
        );
    }

    public function __construct(?string $namespaceName, string $simpleName)
    {
        if ($namespaceName === '') {
            $namespaceName = null;
        }

        $this->namespaceName = $namespaceName;
        $this->simpleName    = $simpleName;
    }

    public function getNamespaceName(): ?string
    {
        return $this->namespaceName;
    }

    public function getSimpleName(): string
    {
        return $this->simpleName;
    }

    public function getQualifiedName(): string
    {
        return $this->namespaceName === null
             ? $this->simpleName
             : $this->namespaceName . '\\' . $this->simpleName;
    }

    public function isNamespaced(): bool
    {
        return $this->namespaceName !== null;
    }
}
