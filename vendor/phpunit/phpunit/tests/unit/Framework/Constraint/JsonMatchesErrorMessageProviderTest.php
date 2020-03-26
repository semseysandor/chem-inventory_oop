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
final class JsonMatchesErrorMessageProviderTest extends TestCase
{
    public static function determineJsonErrorDataprovider(): array
    {
        return [
            'JSON_ERROR_NONE'  => [
                null, 'json_error_none', '',
            ],
            'JSON_ERROR_DEPTH' => [
                'Maximum stack depth exceeded', \JSON_ERROR_DEPTH, '',
            ],
            'prefixed JSON_ERROR_DEPTH' => [
                'TUX: Maximum stack depth exceeded', \JSON_ERROR_DEPTH, 'TUX: ',
            ],
            'JSON_ERROR_STATE_MISMatch' => [
                'Underflow or the modes mismatch', \JSON_ERROR_STATE_MISMATCH, '',
            ],
            'JSON_ERROR_CTRL_CHAR' => [
                'Unexpected control character found', \JSON_ERROR_CTRL_CHAR, '',
            ],
            'JSON_ERROR_SYNTAX' => [
                'Syntax error, malformed JSON', \JSON_ERROR_SYNTAX, '',
            ],
            'JSON_ERROR_UTF8`' => [
                'Malformed UTF-8 characters, possibly incorrectly encoded',
                \JSON_ERROR_UTF8,
                '',
            ],
            'Invalid error indicator' => [
                'Unknown error', 55, '',
            ],
        ];
    }

    public static function translateTypeToPrefixDataprovider(): array
    {
        return [
            'expected' => ['Expected value JSON decode error - ', 'expected'],
            'actual'   => ['Actual value JSON decode error - ', 'actual'],
            'default'  => ['', ''],
        ];
    }

    /**
     * @dataProvider translateTypeToPrefixDataprovider
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testTranslateTypeToPrefix($expected, $type): void
    {
        $this->assertEquals(
            $expected,
            JsonMatchesErrorMessageProvider::translateTypeToPrefix($type)
        );
    }

    /**
     * @testdox Determine JSON error $_dataName
     * @dataProvider determineJsonErrorDataprovider
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testDetermineJsonError($expected, $error, $prefix): void
    {
        $this->assertEquals(
            $expected,
            JsonMatchesErrorMessageProvider::determineJsonError(
                (string) $error,
                $prefix
            )
        );
    }
}
