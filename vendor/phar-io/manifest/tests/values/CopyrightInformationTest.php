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

namespace PharIo\Manifest;

use PHPUnit\Framework\TestCase;

/**
 * @covers PharIo\Manifest\CopyrightInformation
 *
 * @uses PharIo\Manifest\AuthorCollection
 * @uses PharIo\Manifest\AuthorCollectionIterator
 * @uses PharIo\Manifest\Author
 * @uses PharIo\Manifest\Email
 * @uses PharIo\Manifest\License
 * @uses PharIo\Manifest\Url
 */
class CopyrightInformationTest extends TestCase {
    /**
     * @var CopyrightInformation
     */
    private $copyrightInformation;

    /**
     * @var Author
     */
    private $author;

    /**
     * @var License
     */
    private $license;

    protected function setUp() {
        $this->author  = new Author('Joe Developer', new Email('user@example.com'));
        $this->license = new License('BSD-3-Clause', new Url('https://github.com/sebastianbergmann/phpunit/blob/master/LICENSE'));

        $authors = new AuthorCollection;
        $authors->add($this->author);

        $this->copyrightInformation = new CopyrightInformation($authors, $this->license);
    }

    public function testCanBeCreated() {
        $this->assertInstanceOf(CopyrightInformation::class, $this->copyrightInformation);
    }

    public function testAuthorsCanBeRetrieved() {
        $this->assertContains($this->author, $this->copyrightInformation->getAuthors());
    }

    public function testLicenseCanBeRetrieved() {
        $this->assertEquals($this->license, $this->copyrightInformation->getLicense());
    }
}
