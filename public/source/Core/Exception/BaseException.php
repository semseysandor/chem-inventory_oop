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

namespace Inventory\Core\Exception;

use Exception;

/**
 * Base class for Exceptions
 *
 * @category Exception
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class BaseException extends Exception
{
    /**
     * Context of the exception
     *
     * @var string
     */
    protected string $context;

    /**
     * Inventory Exception constructor.
     *
     * @param string|null $context Context of the exception
     */
    public function __construct(string $context = null)
    {
        parent::__construct();
        $this->context = $context;
    }

    /**
     * Gets context
     *
     * @return string|null
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * Prints debug information
     *
     * @return void
     */
    public function print(): void
    {
        // todo: Exception string
        echo "\nException\n".$this->getMessage()." at: ".$this->getContext()."\n";
    }
}
