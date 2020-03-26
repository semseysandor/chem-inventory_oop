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

namespace PHPSTORM_META {

    override(
        \PHPUnit\Framework\TestCase::createMock(0),
        map([
            '@&\PHPUnit\Framework\MockObject\MockObject',
        ])
    );

    override(
        \PHPUnit\Framework\TestCase::createStub(0),
        map([
            '@&\PHPUnit\Framework\MockObject\Stub',
        ])
    );

    override(
        \PHPUnit\Framework\TestCase::createConfiguredMock(0),
        map([
            '@&\PHPUnit\Framework\MockObject\MockObject',
        ])
    );

    override(
        \PHPUnit\Framework\TestCase::createPartialMock(0),
        map([
            '@&\PHPUnit\Framework\MockObject\MockObject',
        ])
    );

    override(
        \PHPUnit\Framework\TestCase::createTestProxy(0),
        map([
            '@&\PHPUnit\Framework\MockObject\MockObject',
        ])
    );

    override(
        \PHPUnit\Framework\TestCase::getMockForAbstractClass(0),
        map([
            '@&\PHPUnit\Framework\MockObject\MockObject',
        ])
    );
}
