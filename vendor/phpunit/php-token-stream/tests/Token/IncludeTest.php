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

use PHPUnit\Framework\TestCase;

class PHP_Token_IncludeTest extends TestCase
{
    /**
     * @var PHP_Token_Stream
     */
    private $ts;

    protected function setUp()
    {
        $this->ts = new PHP_Token_Stream(TEST_FILES_PATH . 'source3.php');
    }

    public function testGetIncludes()
    {
        $this->assertSame(
            ['test4.php', 'test3.php', 'test2.php', 'test1.php'],
            $this->ts->getIncludes()
        );
    }

    public function testGetIncludesCategorized()
    {
        $this->assertSame(
            [
                'require_once' => ['test4.php'],
                'require'      => ['test3.php'],
                'include_once' => ['test2.php'],
                'include'      => ['test1.php']
            ],
            $this->ts->getIncludes(true)
        );
    }

    public function testGetIncludesCategory()
    {
        $this->assertSame(
            ['test4.php'],
            $this->ts->getIncludes(true, 'require_once')
        );
    }
}
