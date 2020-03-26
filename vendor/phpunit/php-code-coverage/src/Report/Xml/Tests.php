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
namespace SebastianBergmann\CodeCoverage\Report\Xml;

final class Tests
{
    private $contextNode;

    private $codeMap = [
        -1 => 'UNKNOWN',    // PHPUnit_Runner_BaseTestRunner::STATUS_UNKNOWN
        0  => 'PASSED',     // PHPUnit_Runner_BaseTestRunner::STATUS_PASSED
        1  => 'SKIPPED',    // PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED
        2  => 'INCOMPLETE', // PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE
        3  => 'FAILURE',    // PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE
        4  => 'ERROR',      // PHPUnit_Runner_BaseTestRunner::STATUS_ERROR
        5  => 'RISKY',      // PHPUnit_Runner_BaseTestRunner::STATUS_RISKY
        6  => 'WARNING',     // PHPUnit_Runner_BaseTestRunner::STATUS_WARNING
    ];

    public function __construct(\DOMElement $context)
    {
        $this->contextNode = $context;
    }

    public function addTest(string $test, array $result): void
    {
        $node = $this->contextNode->appendChild(
            $this->contextNode->ownerDocument->createElementNS(
                'https://schema.phpunit.de/coverage/1.0',
                'test'
            )
        );

        $node->setAttribute('name', $test);
        $node->setAttribute('size', $result['size']);
        $node->setAttribute('result', (string) $result['status']);
        $node->setAttribute('status', $this->codeMap[(int) $result['status']]);
    }
}
