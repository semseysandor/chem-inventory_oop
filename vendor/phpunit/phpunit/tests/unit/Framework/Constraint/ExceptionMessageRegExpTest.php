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

use PHPUnit\Framework\TestCase;

/**
 * @small
 */
final class ExceptionMessageRegExpTest extends TestCase
{
    public function testRegexMessage(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageRegExp('/^A polymorphic \w+ message/');

        throw new \Exception('A polymorphic exception message');
    }

    public function testRegexMessageExtreme(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageRegExp('/^a poly[a-z]+ [a-zA-Z0-9_]+ me(s){2}age$/i');

        throw new \Exception('A polymorphic exception message');
    }

    /**
     * @runInSeparateProcess
     * @requires extension xdebug
     */
    public function testMessageXdebugScreamCompatibility(): void
    {
        \ini_set('xdebug.scream', '1');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessageRegExp('#Screaming preg_match#');

        throw new \Exception('Screaming preg_match');
    }

    public function testRegExMessageCanBeExportedAsString(): void
    {
        $exceptionMessageReExp = new ExceptionMessageRegularExpression('/^a poly[a-z]+ [a-zA-Z0-9_]+ me(s){2}age$/i');

        $this->assertSame('exception message matches ', $exceptionMessageReExp->toString());
    }
}
