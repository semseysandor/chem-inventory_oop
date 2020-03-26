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
namespace PHPUnit\Framework\MockObject;

use PHPUnit\Framework\TestCase;
use PHPUnit\TestFixture\MockObject\AnotherClassUsingConfigurableMethods;
use PHPUnit\TestFixture\MockObject\ClassUsingConfigurableMethods;
use PHPUnit\TestFixture\MockObject\ReinitializeConfigurableMethods;
use SebastianBergmann\Type\SimpleType;

final class ConfigurableMethodsTest extends TestCase
{
    public function testTwoClassesUsingConfigurableMethodsDontInterfere(): void
    {
        $configurableMethodsA = [new ConfigurableMethod('foo', SimpleType::fromValue('boolean', false))];
        $configurableMethodsB = [];
        ClassUsingConfigurableMethods::__phpunit_initConfigurableMethods(...$configurableMethodsA);
        AnotherClassUsingConfigurableMethods::__phpunit_initConfigurableMethods(...$configurableMethodsB);

        $this->assertSame($configurableMethodsA, ClassUsingConfigurableMethods::getConfigurableMethods());
        $this->assertSame($configurableMethodsB, AnotherClassUsingConfigurableMethods::getConfigurableMethods());
    }

    public function testConfigurableMethodsAreImmutable(): void
    {
        ReinitializeConfigurableMethods::__phpunit_initConfigurableMethods();
        $this->expectException(ConfigurableMethodsAlreadyInitializedException::class);
        ReinitializeConfigurableMethods::__phpunit_initConfigurableMethods();
    }
}
