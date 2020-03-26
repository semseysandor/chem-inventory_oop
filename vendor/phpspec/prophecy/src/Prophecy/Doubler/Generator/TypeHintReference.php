<?php
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

namespace Prophecy\Doubler\Generator;

/**
 * Tells whether a keyword refers to a class or to a built-in type for the
 * current version of php
 */
final class TypeHintReference
{
    public function isBuiltInParamTypeHint($type)
    {
        switch ($type) {
            case 'self':
            case 'array':
                return true;

            case 'callable':
                return PHP_VERSION_ID >= 50400;

            case 'bool':
            case 'float':
            case 'int':
            case 'string':
                return PHP_VERSION_ID >= 70000;

            case 'iterable':
                return PHP_VERSION_ID >= 70100;

            case 'object':
                return PHP_VERSION_ID >= 70200;

            default:
                return false;
        }
    }

    public function isBuiltInReturnTypeHint($type)
    {
        if ($type === 'void') {
            return PHP_VERSION_ID >= 70100;
        }

        return $this->isBuiltInParamTypeHint($type);
    }
}
