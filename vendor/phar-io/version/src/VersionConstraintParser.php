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

namespace PharIo\Version;

class VersionConstraintParser {
    /**
     * @param string $value
     *
     * @return VersionConstraint
     *
     * @throws UnsupportedVersionConstraintException
     */
    public function parse($value) {

        if (strpos($value, '||') !== false) {
            return $this->handleOrGroup($value);
        }

        if (!preg_match('/^[\^~\*]?[\d.\*]+(?:-.*)?$/', $value)) {
            throw new UnsupportedVersionConstraintException(
                sprintf('Version constraint %s is not supported.', $value)
            );
        }

        switch ($value[0]) {
            case '~':
                return $this->handleTildeOperator($value);
            case '^':
                return $this->handleCaretOperator($value);
        }

        $version = new VersionConstraintValue($value);

        if ($version->getMajor()->isAny()) {
            return new AnyVersionConstraint();
        }

        if ($version->getMinor()->isAny()) {
            return new SpecificMajorVersionConstraint(
                $version->getVersionString(),
                $version->getMajor()->getValue()
            );
        }

        if ($version->getPatch()->isAny()) {
            return new SpecificMajorAndMinorVersionConstraint(
                $version->getVersionString(),
                $version->getMajor()->getValue(),
                $version->getMinor()->getValue()
            );
        }

        return new ExactVersionConstraint($version->getVersionString());
    }

    /**
     * @param $value
     *
     * @return OrVersionConstraintGroup
     */
    private function handleOrGroup($value) {
        $constraints = [];

        foreach (explode('||', $value) as $groupSegment) {
            $constraints[] = $this->parse(trim($groupSegment));
        }

        return new OrVersionConstraintGroup($value, $constraints);
    }

    /**
     * @param string $value
     *
     * @return AndVersionConstraintGroup
     */
    private function handleTildeOperator($value) {
        $version = new Version(substr($value, 1));
        $constraints = [
            new GreaterThanOrEqualToVersionConstraint($value, $version)
        ];

        if ($version->getPatch()->isAny()) {
            $constraints[] = new SpecificMajorVersionConstraint(
                $value,
                $version->getMajor()->getValue()
            );
        } else {
            $constraints[] = new SpecificMajorAndMinorVersionConstraint(
                $value,
                $version->getMajor()->getValue(),
                $version->getMinor()->getValue()
            );
        }

        return new AndVersionConstraintGroup($value, $constraints);
    }

    /**
     * @param string $value
     *
     * @return AndVersionConstraintGroup
     */
    private function handleCaretOperator($value) {
        $version = new Version(substr($value, 1));

        return new AndVersionConstraintGroup(
            $value,
            [
                new GreaterThanOrEqualToVersionConstraint($value, $version),
                new SpecificMajorVersionConstraint($value, $version->getMajor()->getValue())
            ]
        );
    }
}
