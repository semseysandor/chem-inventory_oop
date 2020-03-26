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

use PHPUnit\Framework\ExpectationFailedException;

/**
 * @small
 */
final class StringMatchesFormatDescriptionTest extends ConstraintTestCase
{
    public function testConstraintStringMatchesDirectorySeparator(): void
    {
        $constraint = new StringMatchesFormatDescription('*%e*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('*a*', '', true));

        $this->assertTrue($constraint->evaluate('*' . \DIRECTORY_SEPARATOR . '*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*\\' . \DIRECTORY_SEPARATOR . '\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesString(): void
    {
        $constraint = new StringMatchesFormatDescription('*%s*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate("*\n*", '', true));

        $this->assertTrue($constraint->evaluate('***', '', true));
        $this->assertTrue($constraint->evaluate('*foo 123 bar*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*[^\r\n]+\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesOptionalString(): void
    {
        $constraint = new StringMatchesFormatDescription('*%S*');

        $this->assertFalse($constraint->evaluate('*', '', true));
        $this->assertFalse($constraint->evaluate("*\n*", '', true));

        $this->assertTrue($constraint->evaluate('***', '', true));
        $this->assertTrue($constraint->evaluate('*foo 123 bar*', '', true));
        $this->assertTrue($constraint->evaluate('**', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*[^\r\n]*\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesAnything(): void
    {
        $constraint = new StringMatchesFormatDescription('*%a*');

        $this->assertFalse($constraint->evaluate('**', '', true));

        $this->assertTrue($constraint->evaluate('***', '', true));
        $this->assertTrue($constraint->evaluate('*foo 123 bar*', '', true));
        $this->assertTrue($constraint->evaluate("*\n*", '', true));

        $this->assertEquals('matches PCRE pattern "/^\*.+\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesOptionalAnything(): void
    {
        $constraint = new StringMatchesFormatDescription('*%A*');

        $this->assertFalse($constraint->evaluate('*', '', true));

        $this->assertTrue($constraint->evaluate('***', '', true));
        $this->assertTrue($constraint->evaluate('*foo 123 bar*', '', true));
        $this->assertTrue($constraint->evaluate("*\n*", '', true));
        $this->assertTrue($constraint->evaluate('**', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*.*\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesWhitespace(): void
    {
        $constraint = new StringMatchesFormatDescription('*%w*');

        $this->assertFalse($constraint->evaluate('*', '', true));
        $this->assertFalse($constraint->evaluate('*a*', '', true));

        $this->assertTrue($constraint->evaluate('* *', '', true));
        $this->assertTrue($constraint->evaluate("*\t\n*", '', true));
        $this->assertTrue($constraint->evaluate('**', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*\s*\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesInteger(): void
    {
        $constraint = new StringMatchesFormatDescription('*%i*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('*a*', '', true));
        $this->assertFalse($constraint->evaluate('*1.0*', '', true));

        $this->assertTrue($constraint->evaluate('*0*', '', true));
        $this->assertTrue($constraint->evaluate('*12*', '', true));
        $this->assertTrue($constraint->evaluate('*-1*', '', true));
        $this->assertTrue($constraint->evaluate('*+2*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*[+-]?\d+\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesUnsignedInt(): void
    {
        $constraint = new StringMatchesFormatDescription('*%d*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('*a*', '', true));
        $this->assertFalse($constraint->evaluate('*1.0*', '', true));
        $this->assertFalse($constraint->evaluate('*-1*', '', true));
        $this->assertFalse($constraint->evaluate('*+2*', '', true));

        $this->assertTrue($constraint->evaluate('*0*', '', true));
        $this->assertTrue($constraint->evaluate('*12*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*\d+\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesHexadecimal(): void
    {
        $constraint = new StringMatchesFormatDescription('*%x*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('***', '', true));
        $this->assertFalse($constraint->evaluate('*g*', '', true));
        $this->assertFalse($constraint->evaluate('*1.0*', '', true));
        $this->assertFalse($constraint->evaluate('*-1*', '', true));
        $this->assertFalse($constraint->evaluate('*+2*', '', true));

        $this->assertTrue($constraint->evaluate('*0f0f0f*', '', true));
        $this->assertTrue($constraint->evaluate('*0*', '', true));
        $this->assertTrue($constraint->evaluate('*12*', '', true));
        $this->assertTrue($constraint->evaluate('*a*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*[0-9a-fA-F]+\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesFloat(): void
    {
        $constraint = new StringMatchesFormatDescription('*%f*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('***', '', true));
        $this->assertFalse($constraint->evaluate('*a*', '', true));

        $this->assertTrue($constraint->evaluate('*1.0*', '', true));
        $this->assertTrue($constraint->evaluate('*0*', '', true));
        $this->assertTrue($constraint->evaluate('*12*', '', true));
        $this->assertTrue($constraint->evaluate('*.1*', '', true));
        $this->assertTrue($constraint->evaluate('*1.*', '', true));
        $this->assertTrue($constraint->evaluate('*2e3*', '', true));
        $this->assertTrue($constraint->evaluate('*-2.34e-56*', '', true));
        $this->assertTrue($constraint->evaluate('*+2.34e+56*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*[+-]?\.?\d+\.?\d*(?:[Ee][+-]?\d+)?\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesCharacter(): void
    {
        $constraint = new StringMatchesFormatDescription('*%c*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('*ab*', '', true));

        $this->assertTrue($constraint->evaluate('***', '', true));
        $this->assertTrue($constraint->evaluate('*a*', '', true));
        $this->assertTrue($constraint->evaluate('*g*', '', true));
        $this->assertTrue($constraint->evaluate('*0*', '', true));
        $this->assertTrue($constraint->evaluate('*2*', '', true));
        $this->assertTrue($constraint->evaluate('* *', '', true));
        $this->assertTrue($constraint->evaluate("*\n*", '', true));

        $this->assertEquals('matches PCRE pattern "/^\*.\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesEscapedPercent(): void
    {
        $constraint = new StringMatchesFormatDescription('%%,%%e,%%s,%%S,%%a,%%A,%%w,%%i,%%d,%%x,%%f,%%c,%%Z,%%%%,%%');

        $this->assertFalse($constraint->evaluate('%%,%' . \DIRECTORY_SEPARATOR . ',%*,%*,%*,%*,% ,%0,%0,%0f0f0f,%1.0,%*,%%Z,%%%%,%%', '', true));
        $this->assertTrue($constraint->evaluate('%,%e,%s,%S,%a,%A,%w,%i,%d,%x,%f,%c,%Z,%%,%', '', true));
        $this->assertEquals('matches PCRE pattern "/^%,%e,%s,%S,%a,%A,%w,%i,%d,%x,%f,%c,%Z,%%,%$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesEscapedPercentThenPlaceholder(): void
    {
        $constraint = new StringMatchesFormatDescription('%%%e,%%%s,%%%S,%%%a,%%%A,%%%w,%%%i,%%%d,%%%x,%%%f,%%%c');

        $this->assertFalse($constraint->evaluate('%%e,%%s,%%S,%%a,%%A,%%w,%%i,%%d,%%x,%%f,%%c', '', true));
        $this->assertTrue($constraint->evaluate('%' . \DIRECTORY_SEPARATOR . ',%*,%*,%*,%*,% ,%0,%0,%0f0f0f,%1.0,%*', '', true));
        $this->assertEquals('matches PCRE pattern "/^%\\' . \DIRECTORY_SEPARATOR . ',%[^\r\n]+,%[^\r\n]*,%.+,%.*,%\s*,%[+-]?\d+,%\d+,%[0-9a-fA-F]+,%[+-]?\.?\d+\.?\d*(?:[Ee][+-]?\d+)?,%.$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesSlash(): void
    {
        $constraint = new StringMatchesFormatDescription('/');

        $this->assertFalse($constraint->evaluate('\\/', '', true));
        $this->assertTrue($constraint->evaluate('/', '', true));
        $this->assertEquals('matches PCRE pattern "/^\\/$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesBackslash(): void
    {
        $constraint = new StringMatchesFormatDescription('\\');

        $this->assertFalse($constraint->evaluate('\\\\', '', true));
        $this->assertTrue($constraint->evaluate('\\', '', true));
        $this->assertEquals('matches PCRE pattern "/^\\\\$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesBackslashSlash(): void
    {
        $constraint = new StringMatchesFormatDescription('\\/');

        $this->assertFalse($constraint->evaluate('/', '', true));
        $this->assertTrue($constraint->evaluate('\\/', '', true));
        $this->assertEquals('matches PCRE pattern "/^\\\\\\/$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesNewline(): void
    {
        $constraint = new StringMatchesFormatDescription("\r\n");

        $this->assertFalse($constraint->evaluate("*\r\n", '', true));
        $this->assertTrue($constraint->evaluate("\r\n", '', true));
        $this->assertEquals("matches PCRE pattern \"/^\n$/s\"", $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testFailureMessageWithNewlines(): void
    {
        $constraint = new StringMatchesFormatDescription("%c\nfoo\n%c");

        try {
            $constraint->evaluate("*\nbar\n*");
            $this->fail('Expected ExpectationFailedException, but it was not thrown.');
        } catch (ExpectationFailedException $e) {
            $expected = <<<EOD
Failed asserting that string matches format description.
--- Expected
+++ Actual
@@ @@
 *
-foo
+bar
 *

EOD;
            $this->assertEquals($expected, $e->getMessage());
        }
    }
}
