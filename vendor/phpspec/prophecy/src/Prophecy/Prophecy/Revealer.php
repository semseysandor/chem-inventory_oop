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

namespace Prophecy\Prophecy;

/**
 * Basic prophecies revealer.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class Revealer implements RevealerInterface
{
    /**
     * Unwraps value(s).
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function reveal($value)
    {
        if (is_array($value)) {
            return array_map(array($this, __FUNCTION__), $value);
        }

        if (!is_object($value)) {
            return $value;
        }

        if ($value instanceof ProphecyInterface) {
            $value = $value->reveal();
        }

        return $value;
    }
}
