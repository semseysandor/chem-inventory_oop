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

class ApplicationName {
    /**
     * @var string
     */
    private $name;

    /**
     * ApplicationName constructor.
     *
     * @param string $name
     *
     * @throws InvalidApplicationNameException
     */
    public function __construct($name) {
        $this->ensureIsString($name);
        $this->ensureValidFormat($name);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->name;
    }

    public function isEqual(ApplicationName $name) {
        return $this->name === $name->name;
    }

    /**
     * @param string $name
     *
     * @throws InvalidApplicationNameException
     */
    private function ensureValidFormat($name) {
        if (!preg_match('#\w/\w#', $name)) {
            throw new InvalidApplicationNameException(
                sprintf('Format of name "%s" is not valid - expected: vendor/packagename', $name),
                InvalidApplicationNameException::InvalidFormat
            );
        }
    }

    private function ensureIsString($name) {
        if (!is_string($name)) {
            throw new InvalidApplicationNameException(
                'Name must be a string',
                InvalidApplicationNameException::NotAString
            );
        }
    }
}
