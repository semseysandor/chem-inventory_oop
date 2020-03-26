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
use SebastianBergmann\GlobalState\TestFixture\BlacklistedInterface;
use SebastianBergmann\GlobalState\TestFixture\SnapshotClass;
use SebastianBergmann\GlobalState\TestFixture\SnapshotTrait;

/**
 * @covers \SebastianBergmann\GlobalState\Snapshot
 *
 * @uses \SebastianBergmann\GlobalState\Blacklist
 */
final class SnapshotTest extends TestCase
{
    /**
     * @var Blacklist
     */
    private $blacklist;

    protected function setUp(): void
    {
        $this->blacklist = new Blacklist;
    }

    public function testStaticAttributes(): void
    {
        SnapshotClass::init();

        $this->blacklistAllLoadedClassesExceptSnapshotClass();

        $snapshot = new Snapshot($this->blacklist, false, true, false, false, false, false, false, false, false);

        $expected = [
            SnapshotClass::class => [
                'string'  => 'string',
                'objects' => [new \stdClass],
            ],
        ];

        $this->assertEquals($expected, $snapshot->staticAttributes());
    }

    public function testConstants(): void
    {
        $snapshot = new Snapshot($this->blacklist, false, false, true, false, false, false, false, false, false);

        $this->assertArrayHasKey('GLOBALSTATE_TESTSUITE', $snapshot->constants());
    }

    public function testFunctions(): void
    {
        $snapshot  = new Snapshot($this->blacklist, false, false, false, true, false, false, false, false, false);
        $functions = $snapshot->functions();

        $this->assertContains('sebastianbergmann\globalstate\testfixture\snapshotfunction', $functions);
        $this->assertNotContains('assert', $functions);
    }

    public function testClasses(): void
    {
        $snapshot = new Snapshot($this->blacklist, false, false, false, false, true, false, false, false, false);
        $classes  = $snapshot->classes();

        $this->assertContains(TestCase::class, $classes);
        $this->assertNotContains(Exception::class, $classes);
    }

    public function testInterfaces(): void
    {
        $snapshot   = new Snapshot($this->blacklist, false, false, false, false, false, true, false, false, false);
        $interfaces = $snapshot->interfaces();

        $this->assertContains(BlacklistedInterface::class, $interfaces);
        $this->assertNotContains(\Countable::class, $interfaces);
    }

    public function testTraits(): void
    {
        \spl_autoload_call('SebastianBergmann\GlobalState\TestFixture\SnapshotTrait');

        $snapshot = new Snapshot($this->blacklist, false, false, false, false, false, false, true, false, false);

        $this->assertContains(SnapshotTrait::class, $snapshot->traits());
    }

    public function testIniSettings(): void
    {
        $snapshot    = new Snapshot($this->blacklist, false, false, false, false, false, false, false, true, false);
        $iniSettings = $snapshot->iniSettings();

        $this->assertArrayHasKey('date.timezone', $iniSettings);
        $this->assertEquals('Etc/UTC', $iniSettings['date.timezone']);
    }

    public function testIncludedFiles(): void
    {
        $snapshot = new Snapshot($this->blacklist, false, false, false, false, false, false, false, false, true);
        $this->assertContains(__FILE__, $snapshot->includedFiles());
    }

    private function blacklistAllLoadedClassesExceptSnapshotClass(): void
    {
        foreach (\get_declared_classes() as $class) {
            if ($class === SnapshotClass::class) {
                continue;
            }

            $this->blacklist->addClass($class);
        }
    }
}
