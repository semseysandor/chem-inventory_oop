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
class ParentClassWithPrivateAttributes
{
    private static $privateStaticParentAttribute = 'foo';

    private $privateParentAttribute              = 'bar';
}

class ParentClassWithProtectedAttributes extends ParentClassWithPrivateAttributes
{
    protected static $protectedStaticParentAttribute = 'foo';

    protected $protectedParentAttribute              = 'bar';
}

class ClassWithNonPublicAttributes extends ParentClassWithProtectedAttributes
{
    public static $publicStaticAttribute       = 'foo';

    protected static $protectedStaticAttribute = 'bar';

    protected static $privateStaticAttribute   = 'baz';

    public $publicAttribute       = 'foo';

    public $foo                   = 1;

    public $bar                   = 2;

    public $publicArray           = ['foo'];

    protected $protectedAttribute = 'bar';

    protected $privateAttribute   = 'baz';

    protected $protectedArray     = ['bar'];

    protected $privateArray       = ['baz'];
}
