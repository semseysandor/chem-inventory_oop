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

use PHPUnit\Framework\TestCase;

class PHP_Token_NamespaceTest extends TestCase
{
    public function testGetName()
    {
        $tokenStream = new PHP_Token_Stream(
          TEST_FILES_PATH . 'classInNamespace.php'
        );

        foreach ($tokenStream as $token) {
            if ($token instanceof PHP_Token_NAMESPACE) {
                $this->assertSame('Foo\\Bar', $token->getName());
            }
        }
    }

    public function testGetStartLineWithUnscopedNamespace()
    {
        foreach (new PHP_Token_Stream(TEST_FILES_PATH . 'classInNamespace.php') as $token) {
            if ($token instanceof PHP_Token_NAMESPACE) {
                $this->assertSame(2, $token->getLine());
            }
        }
    }

    public function testGetEndLineWithUnscopedNamespace()
    {
        foreach (new PHP_Token_Stream(TEST_FILES_PATH . 'classInNamespace.php') as $token) {
            if ($token instanceof PHP_Token_NAMESPACE) {
                $this->assertSame(2, $token->getEndLine());
            }
        }
    }
    public function testGetStartLineWithScopedNamespace()
    {
        foreach (new PHP_Token_Stream(TEST_FILES_PATH . 'classInScopedNamespace.php') as $token) {
            if ($token instanceof PHP_Token_NAMESPACE) {
                $this->assertSame(2, $token->getLine());
            }
        }
    }

    public function testGetEndLineWithScopedNamespace()
    {
        foreach (new PHP_Token_Stream(TEST_FILES_PATH . 'classInScopedNamespace.php') as $token) {
            if ($token instanceof PHP_Token_NAMESPACE) {
                $this->assertSame(8, $token->getEndLine());
            }
        }
    }
}
