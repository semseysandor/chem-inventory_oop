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
use PHPUnit\Framework\TestCase;

class ExceptionInTest extends TestCase
{
    public $setUp                = false;

    public $assertPreConditions  = false;

    public $assertPostConditions = false;

    public $tearDown             = false;

    public $testSomething        = false;

    protected function setUp(): void
    {
        $this->setUp = true;
    }

    protected function tearDown(): void
    {
        $this->tearDown = true;
    }

    public function testSomething(): void
    {
        $this->testSomething = true;

        throw new Exception;
    }

    protected function assertPreConditions(): void
    {
        $this->assertPreConditions = true;
    }

    protected function assertPostConditions(): void
    {
        $this->assertPostConditions = true;
    }
}
