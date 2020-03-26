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

use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Exception;

/**
 * @small
 *
 * @covers \PHPUnit\Util\Annotation\Registry
 *
 * @uses   \PHPUnit\Util\Annotation\DocBlock
 */
final class RegistryTest extends TestCase
{
    public function testRegistryLookupWithExistingClassAnnotation(): void
    {
        $annotation = Registry::getInstance()->forClassName(self::class);

        self::assertSame(
            [
                'small'  => [''],
                'covers' => ['\PHPUnit\Util\Annotation\Registry'],
                'uses'   => ['\PHPUnit\Util\Annotation\DocBlock'],
            ],
            $annotation->symbolAnnotations()
        );

        self::assertSame(
            $annotation,
            Registry::getInstance()->forClassName(self::class),
            'Registry memoizes retrieved DocBlock instances'
        );
    }

    public function testRegistryLookupWithExistingMethodAnnotation(): void
    {
        $annotation = Registry::getInstance()->forMethod(
            \NumericGroupAnnotationTest::class,
            'testTicketAnnotationSupportsNumericValue'
        );

        self::assertSame(
            [
                'testdox' => ['Empty test for @ticket numeric annotation values'],
                'ticket'  => ['3502'],
                'see'     => ['https://github.com/sebastianbergmann/phpunit/issues/3502'],
            ],
            $annotation->symbolAnnotations()
        );

        self::assertSame(
            $annotation,
            Registry::getInstance()->forMethod(
                \NumericGroupAnnotationTest::class,
                'testTicketAnnotationSupportsNumericValue'
            ),
            'Registry memoizes retrieved DocBlock instances'
        );
    }

    public function testClassLookupForAClassThatDoesNotExistFails(): void
    {
        $registry = Registry::getInstance();

        $this->expectException(Exception::class);

        $registry->forClassName(\ThisClassDoesNotExist::class);
    }

    public function testMethodLookupForAMethodThatDoesNotExistFails(): void
    {
        $registry = Registry::getInstance();

        $this->expectException(Exception::class);

        $registry->forMethod(self::class, 'thisMethodDoesNotExist');
    }
}
