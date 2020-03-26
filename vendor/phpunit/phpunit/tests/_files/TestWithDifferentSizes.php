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

final class TestWithDifferentSizes extends TestCase
{
    public function testWithSizeUnknown(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @large
     */
    public function testWithSizeLarge(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @depends testDataProviderWithSizeMedium
     * @medium
     */
    public function testWithSizeMedium(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @small
     */
    public function testWithSizeSmall(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @dataProvider provider
     * @small
     */
    public function testDataProviderWithSizeSmall(bool $value): void
    {
        $this->assertTrue(true);
    }

    /**
     * @dataProvider provider
     * @medium
     */
    public function testDataProviderWithSizeMedium(bool $value): void
    {
        $this->assertTrue(true);
    }

    public function provider(): array
    {
        return [
            [false],
            [true],
        ];
    }
}
