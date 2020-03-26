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

declare(strict_types=1);

namespace SebastianBergmann\ObjectReflector;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\ObjectReflector\TestFixture\ChildClass;
use SebastianBergmann\ObjectReflector\TestFixture\ClassWithIntegerAttributeName;

/**
 * @covers SebastianBergmann\ObjectReflector\ObjectReflector
 */
class ObjectReflectorTest extends TestCase
{
    /**
     * @var ObjectReflector
     */
    private $objectReflector;

    protected function setUp()/*: void */
    {
        $this->objectReflector = new ObjectReflector;
    }

    public function testReflectsAttributesOfObject()/*: void */
    {
        $o = new ChildClass;

        $this->assertEquals(
            [
                'privateInChild' => 'private',
                'protectedInChild' => 'protected',
                'publicInChild' => 'public',
                'undeclared' => 'undeclared',
                'SebastianBergmann\ObjectReflector\TestFixture\ParentClass::privateInParent' => 'private',
                'SebastianBergmann\ObjectReflector\TestFixture\ParentClass::protectedInParent' => 'protected',
                'SebastianBergmann\ObjectReflector\TestFixture\ParentClass::publicInParent' => 'public',
            ],
            $this->objectReflector->getAttributes($o)
        );
    }

    public function testReflectsAttributeWithIntegerName()/*: void */
    {
        $o = new ClassWithIntegerAttributeName;

        $this->assertEquals(
            [
                1 => 2
            ],
            $this->objectReflector->getAttributes($o)
        );
    }

    public function testRaisesExceptionWhenPassedArgumentIsNotAnObject()/*: void */
    {
        $this->expectException(InvalidArgumentException::class);

        $this->objectReflector->getAttributes(null);
    }
}
