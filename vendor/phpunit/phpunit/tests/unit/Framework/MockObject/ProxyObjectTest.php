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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @small
 */
final class ProxyObjectTest extends TestCase
{
    public function testProxyingWorksForMethodThatReturnsUndeclaredScalarValue(): void
    {
        $proxy = $this->createTestProxy(TestProxyFixture::class);

        $proxy->expects($this->once())
              ->method('returnString');

        \assert($proxy instanceof MockObject);
        \assert($proxy instanceof TestProxyFixture);

        $this->assertSame('result', $proxy->returnString());
    }

    public function testProxyingWorksForMethodThatReturnsDeclaredScalarValue(): void
    {
        $proxy = $this->createTestProxy(TestProxyFixture::class);

        $proxy->expects($this->once())
              ->method('returnTypedString');

        \assert($proxy instanceof MockObject);
        \assert($proxy instanceof TestProxyFixture);

        $this->assertSame('result', $proxy->returnTypedString());
    }

    public function testProxyingWorksForMethodThatReturnsUndeclaredObject(): void
    {
        $proxy = $this->createTestProxy(TestProxyFixture::class);

        $proxy->expects($this->once())
              ->method('returnObject');

        \assert($proxy instanceof MockObject);
        \assert($proxy instanceof TestProxyFixture);

        $this->assertSame('bar', $proxy->returnObject()->foo);
    }

    public function testProxyingWorksForMethodThatReturnsDeclaredObject(): void
    {
        $proxy = $this->createTestProxy(TestProxyFixture::class);

        $proxy->expects($this->once())
              ->method('returnTypedObject');

        \assert($proxy instanceof MockObject);
        \assert($proxy instanceof TestProxyFixture);

        $this->assertSame('bar', $proxy->returnTypedObject()->foo);
    }

    public function testProxyingWorksForMethodThatReturnsUndeclaredObjectOfFinalClass(): void
    {
        $proxy = $this->createTestProxy(TestProxyFixture::class);

        $proxy->expects($this->once())
              ->method('returnObjectOfFinalClass');

        \assert($proxy instanceof MockObject);
        \assert($proxy instanceof TestProxyFixture);

        $this->assertSame('value', $proxy->returnObjectOfFinalClass()->value());
    }

    public function testProxyingWorksForMethodThatReturnsDeclaredObjectOfFinalClass(): void
    {
        $proxy = $this->createTestProxy(TestProxyFixture::class);

        $proxy->expects($this->once())
              ->method('returnTypedObjectOfFinalClass');

        \assert($proxy instanceof MockObject);
        \assert($proxy instanceof TestProxyFixture);

        $this->assertSame('value', $proxy->returnTypedObjectOfFinalClass()->value());
    }
}
