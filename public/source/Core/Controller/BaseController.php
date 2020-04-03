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

namespace Inventory\Core\Controller;

use Inventory\Core\Containers\Template;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\IComponent;
use Inventory\Core\Routing\Request;

/**
 * Base Controller Class
 *
 * @category Controller
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
abstract class BaseController implements IComponent
{
    /**
     * HTTP request
     *
     * @var \Inventory\Core\Routing\Request
     */
    protected Request $request;

    /**
     * Container for template data
     *
     * @var \Inventory\Core\Containers\Template
     */
    protected Template $templateContainer;

    /**
     * Core Controller constructor.
     *
     * @param \Inventory\Core\Routing\Request $request HTTP request
     * @param \Inventory\Core\Containers\Template $temp_cont Template container
     */
    public function __construct(Request $request, Template $temp_cont)
    {
        $this->request = $request;
        $this->templateContainer = $temp_cont;
    }

    /**
     * Set base template file
     *
     * @param string $base_template Base template file
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function setBaseTemplate(string $base_template): void
    {
        if (empty($base_template)) {
            throw new BadArgument(ts(sprintf('Base template missing at "%s".', self::class)));
        }
        $this->templateContainer->setBase($base_template);
    }

    /**
     * Set template variable
     *
     * @param string $name Variable name
     * @param mixed $value Variable value
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function setTemplateVar(string $name, $value): void
    {
        if (empty($name)) {
            throw new BadArgument(ts(sprintf('Template variable name missing at "%s".', self::class)));
        }
        $this->templateContainer->setVars($name, $value);
    }

    /**
     * Add template region
     *
     * @param string $region Region name
     * @param string $template Template File
     *
     * @return void
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function setTemplateRegion(string $region, string $template): void
    {
        if (empty($region)) {
            throw new BadArgument(ts(sprintf('Template region name missing at "%s".', self::class)));
        }
        $this->templateContainer->setRegions($region, $template);
    }

    /**
     * Gets Template container
     *
     * @return \Inventory\Core\Containers\Template
     */
    public function getTemplateContainer(): Template
    {
        return $this->templateContainer;
    }

    /**
     * Validate input
     *
     * @return void
     */
    abstract protected function validate(): void;

    /**
     * Process input
     *
     * @return void
     */
    abstract protected function process(): void;

    /**
     * Assemble page
     *
     * @return void
     */
    abstract protected function assemble(): void;

    /**
     * Runs controller
     *
     * @return Template
     */
    public function run(): Template
    {
        // Validate inputs
        $this->validate();

        // Process inputs
        $this->process();

        // Assemble page
        $this->assemble();

        return $this->getTemplateContainer();
    }
}
