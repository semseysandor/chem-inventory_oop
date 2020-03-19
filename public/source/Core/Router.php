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

namespace Inventory\Core;

class Router
{
    public function route()
    {
        $request = new Request();
        $request->parse();

        $route = $request->route;

        if (!is_array($route)) {
            return '\Inventory\Page\Index';
        }

        switch (array_shift($route)) {
            case 'list':
                array_shift($route);
                $controller = 'majom';
                break;
            default:
                $controller = '\Inventory\Page\Index';
        }

        return $controller;
    }
}
