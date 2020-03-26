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
namespace PHPUnit\Framework;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
class SyntheticError extends AssertionFailedError
{
    /**
     * The synthetic file.
     *
     * @var string
     */
    protected $syntheticFile = '';

    /**
     * The synthetic line number.
     *
     * @var int
     */
    protected $syntheticLine = 0;

    /**
     * The synthetic trace.
     *
     * @var array
     */
    protected $syntheticTrace = [];

    public function __construct(string $message, int $code, string $file, int $line, array $trace)
    {
        parent::__construct($message, $code);

        $this->syntheticFile  = $file;
        $this->syntheticLine  = $line;
        $this->syntheticTrace = $trace;
    }

    public function getSyntheticFile(): string
    {
        return $this->syntheticFile;
    }

    public function getSyntheticLine(): int
    {
        return $this->syntheticLine;
    }

    public function getSyntheticTrace(): array
    {
        return $this->syntheticTrace;
    }
}
