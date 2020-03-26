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

use Closure;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class GlobalState
{
    /**
     * @var string[]
     */
    private const SUPER_GLOBAL_ARRAYS = [
        '_ENV',
        '_POST',
        '_GET',
        '_COOKIE',
        '_SERVER',
        '_FILES',
        '_REQUEST',
    ];

    /**
     * @throws Exception
     */
    public static function getIncludedFilesAsString(): string
    {
        return static::processIncludedFilesAsString(\get_included_files());
    }

    /**
     * @param string[] $files
     *
     * @throws Exception
     */
    public static function processIncludedFilesAsString(array $files): string
    {
        $blacklist = new Blacklist;
        $prefix    = false;
        $result    = '';

        if (\defined('__PHPUNIT_PHAR__')) {
            $prefix = 'phar://' . __PHPUNIT_PHAR__ . '/';
        }

        for ($i = \count($files) - 1; $i > 0; $i--) {
            $file = $files[$i];

            if (!empty($GLOBALS['__PHPUNIT_ISOLATION_BLACKLIST']) &&
                \in_array($file, $GLOBALS['__PHPUNIT_ISOLATION_BLACKLIST'])) {
                continue;
            }

            if ($prefix !== false && \strpos($file, $prefix) === 0) {
                continue;
            }

            // Skip virtual file system protocols
            if (\preg_match('/^(vfs|phpvfs[a-z0-9]+):/', $file)) {
                continue;
            }

            if (!$blacklist->isBlacklisted($file) && \is_file($file)) {
                $result = 'require_once \'' . $file . "';\n" . $result;
            }
        }

        return $result;
    }

    public static function getIniSettingsAsString(): string
    {
        $result = '';

        foreach (\ini_get_all(null, false) as $key => $value) {
            $result .= \sprintf(
                '@ini_set(%s, %s);' . "\n",
                self::exportVariable($key),
                self::exportVariable((string) $value)
            );
        }

        return $result;
    }

    public static function getConstantsAsString(): string
    {
        $constants = \get_defined_constants(true);
        $result    = '';

        if (isset($constants['user'])) {
            foreach ($constants['user'] as $name => $value) {
                $result .= \sprintf(
                    'if (!defined(\'%s\')) define(\'%s\', %s);' . "\n",
                    $name,
                    $name,
                    self::exportVariable($value)
                );
            }
        }

        return $result;
    }

    public static function getGlobalsAsString(): string
    {
        $result = '';

        foreach (self::SUPER_GLOBAL_ARRAYS as $superGlobalArray) {
            if (isset($GLOBALS[$superGlobalArray]) && \is_array($GLOBALS[$superGlobalArray])) {
                foreach (\array_keys($GLOBALS[$superGlobalArray]) as $key) {
                    if ($GLOBALS[$superGlobalArray][$key] instanceof Closure) {
                        continue;
                    }

                    $result .= \sprintf(
                        '$GLOBALS[\'%s\'][\'%s\'] = %s;' . "\n",
                        $superGlobalArray,
                        $key,
                        self::exportVariable($GLOBALS[$superGlobalArray][$key])
                    );
                }
            }
        }

        $blacklist   = self::SUPER_GLOBAL_ARRAYS;
        $blacklist[] = 'GLOBALS';

        foreach (\array_keys($GLOBALS) as $key) {
            if (!$GLOBALS[$key] instanceof Closure && !\in_array($key, $blacklist, true)) {
                $result .= \sprintf(
                    '$GLOBALS[\'%s\'] = %s;' . "\n",
                    $key,
                    self::exportVariable($GLOBALS[$key])
                );
            }
        }

        return $result;
    }

    private static function exportVariable($variable): string
    {
        if (\is_scalar($variable) || $variable === null ||
            (\is_array($variable) && self::arrayOnlyContainsScalars($variable))) {
            return \var_export($variable, true);
        }

        return 'unserialize(' . \var_export(\serialize($variable), true) . ')';
    }

    private static function arrayOnlyContainsScalars(array $array): bool
    {
        $result = true;

        foreach ($array as $element) {
            if (\is_array($element)) {
                $result = self::arrayOnlyContainsScalars($element);
            } elseif (!\is_scalar($element) && $element !== null) {
                $result = false;
            }

            if (!$result) {
                break;
            }
        }

        return $result;
    }
}
