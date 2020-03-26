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
 * @small
 * @covers \PHPUnit\Util\XdebugFilterScriptGenerator
 */
final class XDebugFilterScriptGeneratorTest extends TestCase
{
    public function testReturnsExpectedScript(): void
    {
        $expectedDirectory = \sprintf('%s/', __DIR__);
        $expected          = <<<EOF
<?php declare(strict_types=1);
if (!\\function_exists('xdebug_set_filter')) {
    return;
}

\\xdebug_set_filter(
    \\XDEBUG_FILTER_CODE_COVERAGE,
    \\XDEBUG_PATH_WHITELIST,
    [
        '$expectedDirectory',
        '$expectedDirectory',
        '$expectedDirectory',
        'src/foo.php',
        'src/bar.php'
    ]
);

EOF;

        $directoryPathThatDoesNotExist = \sprintf('%s/path/that/does/not/exist', __DIR__);
        $this->assertDirectoryNotExists($directoryPathThatDoesNotExist);

        $filterConfiguration = [
            'include' => [
                'directory' => [
                    [
                        'path'   => __DIR__,
                        'suffix' => '.php',
                        'prefix' => '',
                    ],
                    [
                        'path'   => \sprintf('%s/', __DIR__),
                        'suffix' => '.php',
                        'prefix' => '',
                    ],
                    [
                        'path'   => \sprintf('%s/./%s', \dirname(__DIR__), \basename(__DIR__)),
                        'suffix' => '.php',
                        'prefix' => '',
                    ],
                    [
                        'path'   => $directoryPathThatDoesNotExist,
                        'suffix' => '.php',
                        'prefix' => '',
                    ],
                ],
                'file' => [
                    'src/foo.php',
                    'src/bar.php',
                ],
            ],
            'exclude' => [
                'directory' => [],
                'file'      => [],
            ],
        ];

        $writer = new XdebugFilterScriptGenerator;
        $actual = $writer->generate($filterConfiguration);

        $this->assertSame($expected, $actual);
    }
}
