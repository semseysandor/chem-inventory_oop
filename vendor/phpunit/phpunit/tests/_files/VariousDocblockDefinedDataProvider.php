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
final class VariousDocblockDefinedDataProvider
{
    /**
     * @anotherAnnotation
     */
    public function anotherAnnotation(): void
    {
    }

    /**
     * @testWith [1]
     */
    public function testWith1(): void
    {
    }

    /**
     * @testWith [1, 2]
     * [3, 4]
     */
    public function testWith1234(): void
    {
    }

    /**
     * @testWith ["ab"]
     * [true]
     * [null]
     */
    public function testWithABTrueNull(): void
    {
    }

    /**
     * @testWith [1]
     *           [2]
     * @annotation
     */
    public function testWith12AndAnotherAnnotation(): void
    {
    }

    /**
     * @testWith [1]
     *           [2]
     * blah blah
     */
    public function testWith12AndBlahBlah(): void
    {
    }

    /**
     * @testWith ["\"", "\""]
     */
    public function testWithEscapedString(): void
    {
    }

    /**
     * @testWith [s]
     */
    public function testWithMalformedValue(): void
    {
    }

    /**
     * @testWith ["valid"]
     *           [invalid]
     */
    public function testWithWellFormedAndMalformedValue(): void
    {
    }
}
