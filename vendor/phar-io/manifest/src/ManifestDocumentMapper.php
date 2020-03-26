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
use PharIo\Version\Exception as VersionException;
use PharIo\Version\VersionConstraintParser;

class ManifestDocumentMapper {
    /**
     * @param ManifestDocument $document
     *
     * @returns Manifest
     *
     * @throws ManifestDocumentMapperException
     */
    public function map(ManifestDocument $document) {
        try {
            $contains          = $document->getContainsElement();
            $type              = $this->mapType($contains);
            $copyright         = $this->mapCopyright($document->getCopyrightElement());
            $requirements      = $this->mapRequirements($document->getRequiresElement());
            $bundledComponents = $this->mapBundledComponents($document);

            return new Manifest(
                new ApplicationName($contains->getName()),
                new Version($contains->getVersion()),
                $type,
                $copyright,
                $requirements,
                $bundledComponents
            );
        } catch (VersionException $e) {
            throw new ManifestDocumentMapperException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new ManifestDocumentMapperException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param ContainsElement $contains
     *
     * @return Type
     *
     * @throws ManifestDocumentMapperException
     */
    private function mapType(ContainsElement $contains) {
        switch ($contains->getType()) {
            case 'application':
                return Type::application();
            case 'library':
                return Type::library();
            case 'extension':
                return $this->mapExtension($contains->getExtensionElement());
        }

        throw new ManifestDocumentMapperException(
            sprintf('Unsupported type %s', $contains->getType())
        );
    }

    /**
     * @param CopyrightElement $copyright
     *
     * @return CopyrightInformation
     *
     * @throws InvalidUrlException
     * @throws InvalidEmailException
     */
    private function mapCopyright(CopyrightElement $copyright) {
        $authors = new AuthorCollection();

        foreach($copyright->getAuthorElements() as $authorElement) {
            $authors->add(
                new Author(
                    $authorElement->getName(),
                    new Email($authorElement->getEmail())
                )
            );
        }

        $licenseElement = $copyright->getLicenseElement();
        $license        = new License(
            $licenseElement->getType(),
            new Url($licenseElement->getUrl())
        );

        return new CopyrightInformation(
            $authors,
            $license
        );
    }

    /**
     * @param RequiresElement $requires
     *
     * @return RequirementCollection
     *
     * @throws ManifestDocumentMapperException
     */
    private function mapRequirements(RequiresElement $requires) {
        $collection = new RequirementCollection();
        $phpElement = $requires->getPHPElement();
        $parser     = new VersionConstraintParser;

        try {
            $versionConstraint = $parser->parse($phpElement->getVersion());
        } catch (VersionException $e) {
            throw new ManifestDocumentMapperException(
                sprintf('Unsupported version constraint - %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }

        $collection->add(
            new PhpVersionRequirement(
                $versionConstraint
            )
        );

        if (!$phpElement->hasExtElements()) {
            return $collection;
        }

        foreach($phpElement->getExtElements() as $extElement) {
            $collection->add(
                new PhpExtensionRequirement($extElement->getName())
            );
        }

        return $collection;
    }

    /**
     * @param ManifestDocument $document
     *
     * @return BundledComponentCollection
     */
    private function mapBundledComponents(ManifestDocument $document) {
        $collection = new BundledComponentCollection();

        if (!$document->hasBundlesElement()) {
            return $collection;
        }

        foreach($document->getBundlesElement()->getComponentElements() as $componentElement) {
            $collection->add(
                new BundledComponent(
                    $componentElement->getName(),
                    new Version(
                        $componentElement->getVersion()
                    )
                )
            );
        }

        return $collection;
    }

    /**
     * @param ExtensionElement $extension
     *
     * @return Extension
     *
     * @throws ManifestDocumentMapperException
     */
    private function mapExtension(ExtensionElement $extension) {
        try {
            $parser            = new VersionConstraintParser;
            $versionConstraint = $parser->parse($extension->getCompatible());

            return Type::extension(
                new ApplicationName($extension->getFor()),
                $versionConstraint
            );
        } catch (VersionException $e) {
            throw new ManifestDocumentMapperException(
                sprintf('Unsupported version constraint - %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }
}
