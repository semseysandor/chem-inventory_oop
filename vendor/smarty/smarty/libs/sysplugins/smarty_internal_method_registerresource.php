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

/**
 * Smarty Method RegisterResource
 *
 * Smarty::registerResource() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_RegisterResource
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Registers a resource to fetch a template
     *
     * @api  Smarty::registerResource()
     * @link http://www.smarty.net/docs/en/api.register.resource.tpl
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param string                                                          $name             name of resource type
     * @param Smarty_Resource|array                                           $resource_handler or instance of
     *                                                                                          Smarty_Resource,
     *                                                                                          or array of
     *                                                                                          callbacks to
     *                                                                                          handle
     *                                                                                          resource
     *                                                                                          (deprecated)
     *
     * @return \Smarty|\Smarty_Internal_Template
     */
    public function registerResource(Smarty_Internal_TemplateBase $obj, $name, $resource_handler)
    {
        $smarty = $obj->_getSmartyObj();
        $smarty->registered_resources[ $name ] =
            $resource_handler instanceof Smarty_Resource ? $resource_handler : array($resource_handler, false);
        return $obj;
    }
}
