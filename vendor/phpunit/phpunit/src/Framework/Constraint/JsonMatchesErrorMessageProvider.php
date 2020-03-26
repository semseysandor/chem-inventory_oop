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

/**
 * Provides human readable messages for each JSON error.
 */
final class JsonMatchesErrorMessageProvider
{
    /**
     * Translates JSON error to a human readable string.
     */
    public static function determineJsonError(string $error, string $prefix = ''): ?string
    {
        switch ($error) {
            case \JSON_ERROR_NONE:
                return null;
            case \JSON_ERROR_DEPTH:
                return $prefix . 'Maximum stack depth exceeded';
            case \JSON_ERROR_STATE_MISMATCH:
                return $prefix . 'Underflow or the modes mismatch';
            case \JSON_ERROR_CTRL_CHAR:
                return $prefix . 'Unexpected control character found';
            case \JSON_ERROR_SYNTAX:
                return $prefix . 'Syntax error, malformed JSON';
            case \JSON_ERROR_UTF8:
                return $prefix . 'Malformed UTF-8 characters, possibly incorrectly encoded';
            default:
                return $prefix . 'Unknown error';
        }
    }

    /**
     * Translates a given type to a human readable message prefix.
     */
    public static function translateTypeToPrefix(string $type): string
    {
        switch (\strtolower($type)) {
            case 'expected':
                $prefix = 'Expected value JSON decode error - ';

                break;
            case 'actual':
                $prefix = 'Actual value JSON decode error - ';

                break;
            default:
                $prefix = '';

                break;
        }

        return $prefix;
    }
}
