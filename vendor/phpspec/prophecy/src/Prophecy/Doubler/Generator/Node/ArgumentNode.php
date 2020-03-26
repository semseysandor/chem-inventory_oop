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

namespace Prophecy\Doubler\Generator\Node;

/**
 * Argument node.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class ArgumentNode
{
    private $name;
    private $typeHint;
    private $default;
    private $optional    = false;
    private $byReference = false;
    private $isVariadic  = false;
    private $isNullable  = false;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTypeHint()
    {
        return $this->typeHint;
    }

    public function setTypeHint($typeHint = null)
    {
        $this->typeHint = $typeHint;
    }

    public function hasDefault()
    {
        return $this->isOptional() && !$this->isVariadic();
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function setDefault($default = null)
    {
        $this->optional = true;
        $this->default  = $default;
    }

    public function isOptional()
    {
        return $this->optional;
    }

    public function setAsPassedByReference($byReference = true)
    {
        $this->byReference = $byReference;
    }

    public function isPassedByReference()
    {
        return $this->byReference;
    }

    public function setAsVariadic($isVariadic = true)
    {
        $this->isVariadic = $isVariadic;
    }

    public function isVariadic()
    {
        return $this->isVariadic;
    }

    public function isNullable()
    {
        return $this->isNullable;
    }

    public function setAsNullable($isNullable = true)
    {
        $this->isNullable = $isNullable;
    }
}
