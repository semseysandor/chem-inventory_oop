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

use Inventory\Core\Exception\InvalidRequest;

/**
 * Request Class
 *
 * @category Routing
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Request
{
    /**
     * Request data
     *
     * @var array|null
     */
    private ?array $requestData;

    /**
     * Request method
     *
     * @var string|null
     */
    private ?string $requestMethod;

    /**
     * Route from URI
     *
     * @var array|null
     */
    private ?array $route;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->requestData = null;
        $this->requestMethod = null;
        $this->route = null;
    }

    /**
     * Parse GET & POST data
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    private function parseData(): void
    {
        // Check for request method
        if (!array_key_exists('REQUEST_METHOD', $_SERVER)) {
            throw new InvalidRequest(ts('Missing request method.'));
        }
        // GET or POST
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->requestMethod = 'GET';
                break;
            case 'POST':
                $this->requestMethod = 'POST';
                break;
            default:
                throw new InvalidRequest(ts('Not supported request method "%s".', $_SERVER['REQUEST_METHOD']));
        }
        $this->requestData = $_REQUEST;
    }

    /**
     * Parse route
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    private function parseRoute(): void
    {
        // Check for request URI
        if (!array_key_exists('REQUEST_URI', $_SERVER)) {
            throw new InvalidRequest(ts('Missing request URI.'));
        }

        // Extract route from request URL
        $this->route = explode('/', $_SERVER['REQUEST_URI']);

        // Push delimiter out of array '/'
        if ($this->route) {
            array_shift($this->route);
        } else {
            throw new InvalidRequest(ts('Invalid request URI.'));
        }
    }

    /**
     * Get request data
     *
     * @return array|null
     */
    public function getRequestData(): ?array
    {
        return $this->requestData;
    }

    /**
     * Get request method
     *
     * @return string|null
     */
    public function getRequestMethod(): ?string
    {
        return $this->requestMethod;
    }

    /**
     * Get request route
     *
     * @return array|null
     */
    public function getRoute(): ?array
    {
        return $this->route;
    }

    /**
     * Parse URL
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function parse(): void
    {
        // Parse request data
        $this->parseData();

        // Parse route from request
        $this->parseRoute();
    }
}
