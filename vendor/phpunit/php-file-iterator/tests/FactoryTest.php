<?php
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
namespace SebastianBergmann\FileIterator;

use PHPUnit\Framework\TestCase;

/**
 * @covers \SebastianBergmann\FileIterator\Factory
 */
class FactoryTest extends TestCase
{
    /**
     * @var string
     */
    private $root;

    /**
     * @var Factory
     */
    private $factory;

    protected function setUp(): void
    {
        $this->root    = __DIR__;
        $this->factory = new Factory;
    }

    public function testFindFilesInTestDirectory(): void
    {
        $iterator = $this->factory->getFileIterator($this->root, 'Test.php');
        $files    = \iterator_to_array($iterator);

        $this->assertGreaterThanOrEqual(1, \count($files));
    }

    public function testFindFilesWithExcludedNonExistingSubdirectory(): void
    {
        $iterator = $this->factory->getFileIterator($this->root, 'Test.php', '', [$this->root . '/nonExistingDir']);
        $files    = \iterator_to_array($iterator);

        $this->assertGreaterThanOrEqual(1, \count($files));
    }
}
