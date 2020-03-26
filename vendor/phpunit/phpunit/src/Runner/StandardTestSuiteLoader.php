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
namespace PHPUnit\Runner;

use PHPUnit\Framework\TestCase;
use PHPUnit\Util\FileLoader;
use PHPUnit\Util\Filesystem;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class StandardTestSuiteLoader implements TestSuiteLoader
{
    /**
     * @throws Exception
     * @throws \PHPUnit\Framework\Exception
     */
    public function load(string $suiteClassName, string $suiteClassFile = ''): \ReflectionClass
    {
        $suiteClassName = \str_replace('.php', '', $suiteClassName);
        $filename       = null;

        if (empty($suiteClassFile)) {
            $suiteClassFile = Filesystem::classNameToFilename(
                $suiteClassName
            );
        }

        if (!\class_exists($suiteClassName, false)) {
            $loadedClasses = \get_declared_classes();

            $filename = FileLoader::checkAndLoad($suiteClassFile);

            $loadedClasses = \array_values(
                \array_diff(\get_declared_classes(), $loadedClasses)
            );
        }

        if (!empty($loadedClasses) && !\class_exists($suiteClassName, false)) {
            $offset = 0 - \strlen($suiteClassName);

            foreach ($loadedClasses as $loadedClass) {
                try {
                    $class = new \ReflectionClass($loadedClass);
                    // @codeCoverageIgnoreStart
                } catch (\ReflectionException $e) {
                    throw new Exception(
                        $e->getMessage(),
                        (int) $e->getCode(),
                        $e
                    );
                }
                // @codeCoverageIgnoreEnd

                if (\substr($loadedClass, $offset) === $suiteClassName &&
                    $class->getFileName() == $filename) {
                    $suiteClassName = $loadedClass;

                    break;
                }
            }
        }

        if (!empty($loadedClasses) && !\class_exists($suiteClassName, false)) {
            $testCaseClass = TestCase::class;

            foreach ($loadedClasses as $loadedClass) {
                try {
                    $class = new \ReflectionClass($loadedClass);
                    // @codeCoverageIgnoreStart
                } catch (\ReflectionException $e) {
                    throw new Exception(
                        $e->getMessage(),
                        (int) $e->getCode(),
                        $e
                    );
                }
                // @codeCoverageIgnoreEnd

                $classFile = $class->getFileName();

                if ($class->isSubclassOf($testCaseClass) && !$class->isAbstract()) {
                    $suiteClassName = $loadedClass;
                    $testCaseClass  = $loadedClass;

                    if ($classFile == \realpath($suiteClassFile)) {
                        break;
                    }
                }

                if ($class->hasMethod('suite')) {
                    try {
                        $method = $class->getMethod('suite');
                        // @codeCoverageIgnoreStart
                    } catch (\ReflectionException $e) {
                        throw new Exception(
                            $e->getMessage(),
                            (int) $e->getCode(),
                            $e
                        );
                    }
                    // @codeCoverageIgnoreEnd

                    if (!$method->isAbstract() && $method->isPublic() && $method->isStatic()) {
                        $suiteClassName = $loadedClass;

                        if ($classFile == \realpath($suiteClassFile)) {
                            break;
                        }
                    }
                }
            }
        }

        if (\class_exists($suiteClassName, false)) {
            try {
                $class = new \ReflectionClass($suiteClassName);
                // @codeCoverageIgnoreStart
            } catch (\ReflectionException $e) {
                throw new Exception(
                    $e->getMessage(),
                    (int) $e->getCode(),
                    $e
                );
            }
            // @codeCoverageIgnoreEnd

            if ($class->getFileName() == \realpath($suiteClassFile)) {
                return $class;
            }
        }

        throw new Exception(
            \sprintf(
                "Class '%s' could not be found in '%s'.",
                $suiteClassName,
                $suiteClassFile
            )
        );
    }

    public function reload(\ReflectionClass $aClass): \ReflectionClass
    {
        return $aClass;
    }
}
