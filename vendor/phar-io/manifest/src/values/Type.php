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

use PharIo\Version\VersionConstraint;

abstract class Type {
    /**
     * @return Application
     */
    public static function application() {
        return new Application;
    }

    /**
     * @return Library
     */
    public static function library() {
        return new Library;
    }

    /**
     * @param ApplicationName   $application
     * @param VersionConstraint $versionConstraint
     *
     * @return Extension
     */
    public static function extension(ApplicationName $application, VersionConstraint $versionConstraint) {
        return new Extension($application, $versionConstraint);
    }

    /**
     * @return bool
     */
    public function isApplication() {
        return false;
    }

    /**
     * @return bool
     */
    public function isLibrary() {
        return false;
    }

    /**
     * @return bool
     */
    public function isExtension() {
        return false;
    }
}
