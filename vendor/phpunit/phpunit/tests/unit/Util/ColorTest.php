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
namespace PHPUnit\Util;

use PHPUnit\Framework\TestCase;

/**
 * @testdox Basic ANSI color highlighting support
 * @small
 */
final class ColorTest extends TestCase
{
    /**
     * @testdox Colorize with $_dataName
     * @dataProvider colorizeProvider
     */
    public function testColorize(string $color, string $buffer, string $expected): void
    {
        $this->assertSame($expected, Color::colorize($color, $buffer));
    }

    /**
     * @testdox Colorize path $path after $prevPath
     * @dataProvider colorizePathProvider
     */
    public function testColorizePath(?string $prevPath, string $path, bool $colorizeFilename, string $expected): void
    {
        $this->assertSame($expected, Color::colorizePath($path, $prevPath, $colorizeFilename));
    }

    /**
     * @testdox dim($m) and colorize('dim',$m) return different ANSI codes
     */
    public function testDimAndColorizeDimAreDifferent(): void
    {
        $buffer = 'some string';
        $this->assertNotSame(Color::dim($buffer), Color::colorize('dim', $buffer));
    }

    /**
     * @testdox Visualize all whitespace characters in $actual
     * @dataProvider whitespacedStringProvider
     */
    public function testVisibleWhitespace(string $actual, string $expected): void
    {
        $this->assertSame($expected, Color::visualizeWhitespace($actual, true));
    }

    /**
     * @testdox Visualize whitespace but ignore EOL
     */
    public function testVisibleWhitespaceWithoutEOL(): void
    {
        $string = "line1\nline2\n";
        $this->assertSame($string, Color::visualizeWhitespace($string, false));
    }

    /**
     * @dataProvider unnamedDataSetProvider
     */
    public function testPrettifyUnnamedDataprovider(int $value): void
    {
        $this->assertSame($value, $value);
    }

    /**
     * @dataProvider namedDataSetProvider
     */
    public function testPrettifyNamedDataprovider(int $value): void
    {
        $this->assertSame($value, $value);
    }

    /**
     * @testdox TestDox shows name of data set $_dataName with value $value
     * @dataProvider namedDataSetProvider
     */
    public function testTestdoxDatanameAsParameter(int $value): void
    {
        $this->assertSame($value, $value);
    }

    public function colorizeProvider(): array
    {
        return [
            'no color'                 => ['', 'string', 'string'],
            'one color'                => ['fg-blue', 'string', "\x1b[34mstring\x1b[0m"],
            'multiple colors'          => ['bold,dim,fg-blue,bg-yellow', 'string', "\x1b[1;2;34;43mstring\x1b[0m"],
            'invalid color'            => ['fg-invalid', 'some text', 'some text'],
            'valid and invalid colors' => ['fg-invalid,bg-blue', 'some text', "\e[44msome text\e[0m"],
        ];
    }

    public function colorizePathProvider(): array
    {
        $sep    = \DIRECTORY_SEPARATOR;
        $sepDim = Color::dim($sep);

        return [
            'null previous path' => [
                null,
                $sep . 'php' . $sep . 'unit' . $sep . 'test.phpt',
                false,
                $sepDim . 'php' . $sepDim . 'unit' . $sepDim . 'test.phpt',
            ],
            'empty previous path' => [
                '',
                $sep . 'php' . $sep . 'unit' . $sep . 'test.phpt',
                false,
                $sepDim . 'php' . $sepDim . 'unit' . $sepDim . 'test.phpt',
            ],
            'from root' => [
                $sep,
                $sep . 'php' . $sep . 'unit' . $sep . 'test.phpt',
                false,
                $sepDim . 'php' . $sepDim . 'unit' . $sepDim . 'test.phpt',
            ],
            'partial part' => [
                $sep . 'php' . $sep,
                $sep . 'php' . $sep . 'unit' . $sep . 'test.phpt',
                false,
                Color::dim($sep . 'php' . $sep) . 'unit' . $sepDim . 'test.phpt',
            ],
            'colorize filename' => [
                '',
                $sep . '_d-i.r' . $sep . 't-e_s.t.phpt',
                true,
                $sepDim . '_d-i.r' . $sepDim . 't' . Color::dim('-') . 'e' . Color::dim('_') . 's' . Color::dim('.') . 't' . Color::dim('.phpt'),
            ],
        ];
    }

    public function whitespacedStringProvider(): array
    {
        return [
            ['no-spaces',
                'no-spaces',
            ],
            [
                ' space   invaders ',
                "\e[2m·\e[22mspace\e[2m···\e[22minvaders\e[2m·\e[22m",
            ],
            [
                "\tindent, space and \\n\n\\r\r",
                "\e[2m⇥\e[22mindent,\e[2m·\e[22mspace\e[2m·\e[22mand\e[2m·\e[22m\\n\e[2m↵\e[22m\\r\e[2m⟵\e[22m",
            ],
        ];
    }

    public function unnamedDataSetProvider(): array
    {
        return [
            [1],
            [2],
        ];
    }

    public function namedDataSetProvider(): array
    {
        return [
            'one' => [1],
            'two' => [2],
        ];
    }
}
