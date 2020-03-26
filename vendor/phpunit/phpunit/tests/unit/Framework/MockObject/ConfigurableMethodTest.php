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
use SebastianBergmann\Type\Type;

final class ConfigurableMethodTest extends TestCase
{
    public function testMethodMayReturnAssignableValue(): void
    {
        $assignableType = $this->createMock(Type::class);
        $assignableType->method('isAssignable')
            ->willReturn(true);
        $configurable = new ConfigurableMethod('foo', $assignableType);
        $this->assertTrue($configurable->mayReturn('everything-is-valid'));
    }

    public function testMethodMayNotReturnUnassignableValue(): void
    {
        $unassignableType = $this->createMock(Type::class);
        $unassignableType->method('isAssignable')
            ->willReturn(false);
        $configurable = new ConfigurableMethod('foo', $unassignableType);
        $this->assertFalse($configurable->mayReturn('everything-is-invalid'));
    }
}
