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

namespace SebastianBergmann\CodeUnitReverseLookup;

use PHPUnit\Framework\TestCase;

/**
 * @covers SebastianBergmann\CodeUnitReverseLookup\Wizard
 */
class WizardTest extends TestCase
{
    /**
     * @var Wizard
     */
    private $wizard;

    protected function setUp()
    {
        $this->wizard = new Wizard;
    }

    public function testMethodCanBeLookedUp()
    {
        $this->assertEquals(
            __METHOD__,
            $this->wizard->lookup(__FILE__, __LINE__)
        );
    }

    public function testReturnsFilenameAndLineNumberAsStringWhenNotInCodeUnit()
    {
        $this->assertEquals(
            'file.php:1',
            $this->wizard->lookup('file.php', 1)
        );
    }
}
