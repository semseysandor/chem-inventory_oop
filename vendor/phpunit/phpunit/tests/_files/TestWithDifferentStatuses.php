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
use PHPUnit\Framework\TestCase;

final class TestWithDifferentStatuses extends TestCase
{
    public function testThatFails(): void
    {
        $this->fail();
    }

    public function testThatErrors(): void
    {
        throw new \Exception();
    }

    public function testThatPasses(): void
    {
        $this->assertTrue(true);
    }

    public function testThatIsMarkedAsIncomplete(): void
    {
        $this->markTestIncomplete();
    }

    public function testThatIsMarkedAsRisky(): void
    {
        $this->markAsRisky();
    }

    public function testThatIsMarkedAsSkipped(): void
    {
        $this->markTestSkipped();
    }

    public function testThatAddsAWarning(): void
    {
        $this->addWarning('Sorry, Dave!');
    }

    public function testWithCreatePartialMockWarning(): void
    {
        $this->createPartialMock(\Mockable::class, ['mockableMethod', 'fakeMethod1', 'fakeMethod2']);
    }

    public function testWithCreatePartialMockPassesNoWarning(): void
    {
        $mock = $this->createPartialMock(\Mockable::class, ['mockableMethod']);
        $this->assertNull($mock->mockableMethod());
    }
}
