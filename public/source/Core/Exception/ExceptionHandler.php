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

use SmartyException;

/**
 * Exception Handler
 *
 * @category Exception
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class ExceptionHandler
{
    /**
     * Handles Invalid Request exception
     *
     * @param \Inventory\Core\Exception\InvalidRequest $ex
     *
     * @return void
     */
    public static function handleInvalidRequest(InvalidRequest $ex): void
    {
        $ex->print();
        exit;
    }

    /**
     * Handles Smarty Exception
     *
     * @param \SmartyException $ex
     *
     * @return void
     */
    public static function handleSmarty(SmartyException $ex): void
    {
        echo "smarty problem";
        echo $ex->getMessage();
        exit;
    }

    /**
     * Handles Renderer Errors
     *
     * @param \Inventory\Core\Exception\BaseException $ex
     *
     * @return void
     */
    public static function handleRendererErrors(BaseException $ex): void
    {
        echo "renderer problem";
        $ex->print();
        exit;
    }
}
