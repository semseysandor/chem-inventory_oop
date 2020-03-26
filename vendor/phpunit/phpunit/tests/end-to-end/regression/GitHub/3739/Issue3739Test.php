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
namespace Issue3739;

use PHPUnit\Framework\TestCase;

class Issue3739
{
    public function unlinkFileThatDoesNotExistWithErrorSuppression(): bool
    {
        return @\unlink(__DIR__ . '/DOES_NOT_EXIST');
    }

    public function unlinkFileThatDoesNotExistWithoutErrorSuppression(): bool
    {
        return \unlink(__DIR__ . '/DOES_NOT_EXIST');
    }
}

final class Issue3739Test extends TestCase
{
    public function testWithErrorSuppression(): void
    {
        $this->assertFalse((new Issue3739())->unlinkFileThatDoesNotExistWithErrorSuppression());
    }

    public function testWithoutErrorSuppression(): void
    {
        $this->assertFalse((new Issue3739())->unlinkFileThatDoesNotExistWithoutErrorSuppression());
    }
}
