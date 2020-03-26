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

use PharIo\Version\Version;
use PharIo\Version\VersionConstraint;

class Extension extends Type {
    /**
     * @var ApplicationName
     */
    private $application;

    /**
     * @var VersionConstraint
     */
    private $versionConstraint;

    /**
     * @param ApplicationName   $application
     * @param VersionConstraint $versionConstraint
     */
    public function __construct(ApplicationName $application, VersionConstraint $versionConstraint) {
        $this->application       = $application;
        $this->versionConstraint = $versionConstraint;
    }

    /**
     * @return ApplicationName
     */
    public function getApplicationName() {
        return $this->application;
    }

    /**
     * @return VersionConstraint
     */
    public function getVersionConstraint() {
        return $this->versionConstraint;
    }

    /**
     * @return bool
     */
    public function isExtension() {
        return true;
    }

    /**
     * @param ApplicationName $name
     *
     * @return bool
     */
    public function isExtensionFor(ApplicationName $name) {
        return $this->application->isEqual($name);
    }

    /**
     * @param ApplicationName $name
     * @param Version         $version
     *
     * @return bool
     */
    public function isCompatibleWith(ApplicationName $name, Version $version) {
        return $this->isExtensionFor($name) && $this->versionConstraint->complies($version);
    }
}
