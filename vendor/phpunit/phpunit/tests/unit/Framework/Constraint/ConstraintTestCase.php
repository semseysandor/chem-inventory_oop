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
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\SelfDescribing;
use PHPUnit\Framework\TestCase;

/**
 * @small
 */
abstract class ConstraintTestCase extends TestCase
{
    final public function testIsCountable(): void
    {
        $className = $this->className();

        $reflection = new \ReflectionClass($className);

        $this->assertTrue($reflection->implementsInterface(\Countable::class), \sprintf(
            'Failed to assert that "%s" implements "%s".',
            $className,
            \Countable::class
        ));
    }

    final public function testIsSelfDescribing(): void
    {
        $className = $this->className();

        $reflection = new \ReflectionClass($className);

        $this->assertTrue($reflection->implementsInterface(SelfDescribing::class), \sprintf(
            'Failed to assert that "%s" implements "%s".',
            $className,
            SelfDescribing::class
        ));
    }

    /**
     * Returns the class name of the constraint.
     */
    final protected function className(): string
    {
        return \preg_replace(
            '/Test$/',
            '',
            static::class
        );
    }
}
