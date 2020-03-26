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

use PHPUnit\Framework\Exception;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class Json
{
    /**
     * Prettify json string
     *
     * @throws \PHPUnit\Framework\Exception
     */
    public static function prettify(string $json): string
    {
        $decodedJson = \json_decode($json, true);

        if (\json_last_error()) {
            throw new Exception(
                'Cannot prettify invalid json'
            );
        }

        return \json_encode($decodedJson, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE);
    }

    /*
     * To allow comparison of JSON strings, first process them into a consistent
     * format so that they can be compared as strings.
     * @return array ($error, $canonicalized_json)  The $error parameter is used
     * to indicate an error decoding the json.  This is used to avoid ambiguity
     * with JSON strings consisting entirely of 'null' or 'false'.
     */
    public static function canonicalize(string $json): array
    {
        $decodedJson = \json_decode($json);

        if (\json_last_error()) {
            return [true, null];
        }

        self::recursiveSort($decodedJson);

        $reencodedJson = \json_encode($decodedJson);

        return [false, $reencodedJson];
    }

    /*
     * JSON object keys are unordered while PHP array keys are ordered.
     * Sort all array keys to ensure both the expected and actual values have
     * their keys in the same order.
     */
    private static function recursiveSort(&$json): void
    {
        if (!\is_array($json)) {
            // If the object is not empty, change it to an associative array
            // so we can sort the keys (and we will still re-encode it
            // correctly, since PHP encodes associative arrays as JSON objects.)
            // But EMPTY objects MUST remain empty objects. (Otherwise we will
            // re-encode it as a JSON array rather than a JSON object.)
            // See #2919.
            if (\is_object($json) && \count((array) $json) > 0) {
                $json = (array) $json;
            } else {
                return;
            }
        }

        \ksort($json);

        foreach ($json as $key => &$value) {
            self::recursiveSort($value);
        }
    }
}
