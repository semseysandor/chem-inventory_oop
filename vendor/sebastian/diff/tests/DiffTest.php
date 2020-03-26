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

namespace SebastianBergmann\Diff;

use PHPUnit\Framework\TestCase;

/**
 * @covers SebastianBergmann\Diff\Diff
 *
 * @uses SebastianBergmann\Diff\Chunk
 */
final class DiffTest extends TestCase
{
    public function testGettersAfterConstructionWithDefault(): void
    {
        $from = 'line1a';
        $to   = 'line2a';
        $diff = new Diff($from, $to);

        $this->assertSame($from, $diff->getFrom());
        $this->assertSame($to, $diff->getTo());
        $this->assertSame([], $diff->getChunks(), 'Expect chunks to be default value "array()".');
    }

    public function testGettersAfterConstructionWithChunks(): void
    {
        $from   = 'line1b';
        $to     = 'line2b';
        $chunks = [new Chunk(), new Chunk(2, 3)];

        $diff = new Diff($from, $to, $chunks);

        $this->assertSame($from, $diff->getFrom());
        $this->assertSame($to, $diff->getTo());
        $this->assertSame($chunks, $diff->getChunks(), 'Expect chunks to be passed value.');
    }

    public function testSetChunksAfterConstruction(): void
    {
        $diff = new Diff('line1c', 'line2c');
        $this->assertSame([], $diff->getChunks(), 'Expect chunks to be default value "array()".');

        $chunks = [new Chunk(), new Chunk(2, 3)];
        $diff->setChunks($chunks);
        $this->assertSame($chunks, $diff->getChunks(), 'Expect chunks to be passed value.');
    }
}
