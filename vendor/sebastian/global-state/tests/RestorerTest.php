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
namespace SebastianBergmann\GlobalState;

use PHPUnit\Framework\TestCase;

/**
 * @covers \SebastianBergmann\GlobalState\Restorer
 *
 * @uses \SebastianBergmann\GlobalState\Blacklist
 * @uses \SebastianBergmann\GlobalState\Snapshot
 */
final class RestorerTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $GLOBALS['varBool'] = false;
        $GLOBALS['varNull'] = null;
        $_GET['varGet']     = 0;
    }

    public function testRestorerGlobalVariable(): void
    {
        $snapshot = new Snapshot(null, true, false, false, false, false, false, false, false, false);
        $restorer = new Restorer;
        $restorer->restoreGlobalVariables($snapshot);

        $this->assertArrayHasKey('varBool', $GLOBALS);
        $this->assertEquals(false, $GLOBALS['varBool']);
        $this->assertArrayHasKey('varNull', $GLOBALS);
        $this->assertEquals(null, $GLOBALS['varNull']);
        $this->assertArrayHasKey('varGet', $_GET);
        $this->assertEquals(0, $_GET['varGet']);
    }

    /**
     * @backupGlobals enabled
     */
    public function testIntegrationRestorerGlobalVariables(): void
    {
        $this->assertArrayHasKey('varBool', $GLOBALS);
        $this->assertEquals(false, $GLOBALS['varBool']);
        $this->assertArrayHasKey('varNull', $GLOBALS);
        $this->assertEquals(null, $GLOBALS['varNull']);
        $this->assertArrayHasKey('varGet', $_GET);
        $this->assertEquals(0, $_GET['varGet']);
    }

    /**
     * @depends testIntegrationRestorerGlobalVariables
     */
    public function testIntegrationRestorerGlobalVariables2(): void
    {
        $this->assertArrayHasKey('varBool', $GLOBALS);
        $this->assertEquals(false, $GLOBALS['varBool']);
        $this->assertArrayHasKey('varNull', $GLOBALS);
        $this->assertEquals(null, $GLOBALS['varNull']);
        $this->assertArrayHasKey('varGet', $_GET);
        $this->assertEquals(0, $_GET['varGet']);
    }
}
