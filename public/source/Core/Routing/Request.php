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

namespace Inventory\Core\Routing;

/**
 * Request Class
 *
 * @category Routing
 * @package  Inventory
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Request
{
    /**
     * Query string from URL
     *
     * @var string|null
     */
    public ?string $query;

    /**
     * GET request parameters
     *
     * @var array|null
     */
    public ?array $get;

    /**
     * POST request parameters
     *
     * @var array|null
     */
    public ?array $post;

    /**
     * Route from URI
     *
     * @var array|null
     */
    public ?array $route = null;

    /**
     * Parse route from URL
     */
    public function parse()
    {
        if (array_key_exists('REQUEST_METHOD', $_SERVER)) {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $this->get = $_REQUEST;
                    break;
                case 'POST':
                    $this->post = $_REQUEST;
                    break;
            }
        }

        if (array_key_exists('QUERY_STRING', $_SERVER)) {
            $this->query = $_SERVER['QUERY_STRING'];
        }
        if (array_key_exists('SCRIPT_URL', $_SERVER)) {
            $this->route = explode('/', $_SERVER['SCRIPT_URL']);
        }
        if ($this->route) {
            array_shift($this->route);
        }
    }
}
