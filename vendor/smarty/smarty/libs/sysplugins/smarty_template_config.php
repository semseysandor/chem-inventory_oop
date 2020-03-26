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
 * Smarty Config Source Plugin
 *
 * @package    Smarty
 * @subpackage TemplateResources
 * @author     Uwe Tews
 */

/**
 * Smarty Config Resource Data Object
 * Meta Data Container for Template Files
 *
 * @package    Smarty
 * @subpackage TemplateResources
 * @author     Uwe Tews
 */
class Smarty_Template_Config extends Smarty_Template_Source
{
    /**
     * array of section names, single section or null
     *
     * @var null|string|array
     */
    public $config_sections = null;

    /**
     * scope into which the config variables shall be loaded
     *
     * @var int
     */
    public $scope = 0;

    /**
     * Flag that source is a config file
     *
     * @var bool
     */
    public $isConfig = true;

    /**
     * Name of the Class to compile this resource's contents with
     *
     * @var string
     */
    public $compiler_class = 'Smarty_Internal_Config_File_Compiler';

    /**
     * Name of the Class to tokenize this resource's contents with
     *
     * @var string
     */
    public $template_lexer_class = 'Smarty_Internal_Configfilelexer';

    /**
     * Name of the Class to parse this resource's contents with
     *
     * @var string
     */
    public $template_parser_class = 'Smarty_Internal_Configfileparser';

    /**
     * initialize Source Object for given resource
     * Either [$_template] or [$smarty, $template_resource] must be specified
     *
     * @param Smarty_Internal_Template $_template         template object
     * @param Smarty                   $smarty            smarty object
     * @param string                   $template_resource resource identifier
     *
     * @return Smarty_Template_Config Source Object
     * @throws SmartyException
     */
    public static function load(
        Smarty_Internal_Template $_template = null,
        Smarty $smarty = null,
        $template_resource = null
    ) {
        static $_incompatible_resources = array('extends' => true, 'php' => true);
        if ($_template) {
            $smarty = $_template->smarty;
            $template_resource = $_template->template_resource;
        }
        if (empty($template_resource)) {
            throw new SmartyException('Source: Missing  name');
        }
        // parse resource_name, load resource handler
        list($name, $type) = Smarty_Resource::parseResourceName($template_resource, $smarty->default_config_type);
        // make sure configs are not loaded via anything smarty can't handle
        if (isset($_incompatible_resources[ $type ])) {
            throw new SmartyException("Unable to use resource '{$type}' for config");
        }
        $source = new Smarty_Template_Config($smarty, $template_resource, $type, $name);
        $source->handler->populate($source, $_template);
        if (!$source->exists && isset($smarty->default_config_handler_func)) {
            Smarty_Internal_Method_RegisterDefaultTemplateHandler::_getDefaultTemplate($source);
            $source->handler->populate($source, $_template);
        }
        return $source;
    }
}
