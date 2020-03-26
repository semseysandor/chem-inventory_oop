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

namespace SebastianBergmann\Diff;

final class ConfigurationException extends InvalidArgumentException
{
    /**
     * @param string          $option
     * @param string          $expected
     * @param mixed           $value
     * @param int             $code
     * @param null|\Exception $previous
     */
    public function __construct(
        string $option,
        string $expected,
        $value,
        int $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct(
            \sprintf(
                'Option "%s" must be %s, got "%s".',
                $option,
                $expected,
                \is_object($value) ? \get_class($value) : (null === $value ? '<null>' : \gettype($value) . '#' . $value)
            ),
            $code,
            $previous
        );
    }
}
