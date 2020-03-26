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

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection\Types;

use InvalidArgumentException;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Type;
use function strpos;

/**
 * Value Object representing an object.
 *
 * An object can be either typed or untyped. When an object is typed it means that it has an identifier, the FQSEN,
 * pointing to an element in PHP. Object types that are untyped do not refer to a specific class but represent objects
 * in general.
 */
final class Object_ implements Type
{
    /** @var Fqsen|null */
    private $fqsen;

    /**
     * Initializes this object with an optional FQSEN, if not provided this object is considered 'untyped'.
     *
     * @throws InvalidArgumentException When provided $fqsen is not a valid type.
     */
    public function __construct(?Fqsen $fqsen = null)
    {
        if (strpos((string) $fqsen, '::') !== false || strpos((string) $fqsen, '()') !== false) {
            throw new InvalidArgumentException(
                'Object types can only refer to a class, interface or trait but a method, function, constant or '
                . 'property was received: ' . (string) $fqsen
            );
        }

        $this->fqsen = $fqsen;
    }

    /**
     * Returns the FQSEN associated with this object.
     */
    public function getFqsen() : ?Fqsen
    {
        return $this->fqsen;
    }

    public function __toString() : string
    {
        if ($this->fqsen) {
            return (string) $this->fqsen;
        }

        return 'object';
    }
}
