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
use PHPUnit\TestFixture\MockObject\MockClassWithConfigurableMethods;
use SebastianBergmann\Type\Type;

final class MockClassTest extends TestCase
{
    public function testGenerateClassFromSource(): void
    {
        $mockName = 'PHPUnit\TestFixture\MockObject\MockClassGenerated';

        $file = __DIR__ . '/../../../_files/mock-object/MockClassGenerated.tpl';

        $mockClass = new MockClass(\file_get_contents($file), $mockName, []);
        $mockClass->generate();

        $this->assertTrue(\class_exists($mockName));
    }

    public function testGenerateReturnsNameOfGeneratedClass(): void
    {
        $mockName = 'PHPUnit\TestFixture\MockObject\MockClassGenerated';

        $mockClass = new MockClass('', $mockName, []);

        $this->assertEquals($mockName, $mockClass->generate());
    }

    public function testConfigurableMethodsAreInitalized(): void
    {
        $configurableMethods = [new ConfigurableMethod('foo', Type::fromName('void', false))];
        $mockClass           = new MockClass('', MockClassWithConfigurableMethods::class, $configurableMethods);
        $mockClass->generate();

        $this->assertSame($configurableMethods, MockClassWithConfigurableMethods::getConfigurableMethods());
    }
}
