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
 * @covers SebastianBergmann\Diff\Chunk
 */
final class ChunkTest extends TestCase
{
    /**
     * @var Chunk
     */
    private $chunk;

    protected function setUp(): void
    {
        $this->chunk = new Chunk;
    }

    public function testHasInitiallyNoLines(): void
    {
        $this->assertSame([], $this->chunk->getLines());
    }

    public function testCanBeCreatedWithoutArguments(): void
    {
        $this->assertInstanceOf(Chunk::class, $this->chunk);
    }

    public function testStartCanBeRetrieved(): void
    {
        $this->assertSame(0, $this->chunk->getStart());
    }

    public function testStartRangeCanBeRetrieved(): void
    {
        $this->assertSame(1, $this->chunk->getStartRange());
    }

    public function testEndCanBeRetrieved(): void
    {
        $this->assertSame(0, $this->chunk->getEnd());
    }

    public function testEndRangeCanBeRetrieved(): void
    {
        $this->assertSame(1, $this->chunk->getEndRange());
    }

    public function testLinesCanBeRetrieved(): void
    {
        $this->assertSame([], $this->chunk->getLines());
    }

    public function testLinesCanBeSet(): void
    {
        $lines = [new Line(Line::ADDED, 'added'), new Line(Line::REMOVED, 'removed')];

        $this->chunk->setLines($lines);

        $this->assertSame($lines, $this->chunk->getLines());
    }
}
