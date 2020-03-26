<?php declare(strict_types=1);
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
namespace PHPUnit\Framework\MockObject;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class MockClass implements MockType
{
    /**
     * @var string
     */
    private $classCode;

    /**
     * @var string
     */
    private $mockName;

    /**
     * @var ConfigurableMethod[]
     */
    private $configurableMethods;

    public function __construct(string $classCode, string $mockName, array $configurableMethods)
    {
        $this->classCode           = $classCode;
        $this->mockName            = $mockName;
        $this->configurableMethods = $configurableMethods;
    }

    public function generate(): string
    {
        if (!\class_exists($this->mockName, false)) {
            eval($this->classCode);

            \call_user_func(
                [
                    $this->mockName,
                    '__phpunit_initConfigurableMethods',
                ],
                ...$this->configurableMethods
            );
        }

        return $this->mockName;
    }

    public function getClassCode(): string
    {
        return $this->classCode;
    }
}
