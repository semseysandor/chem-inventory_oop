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
namespace SebastianBergmann\CodeCoverage\Report\Html;

use SebastianBergmann\CodeCoverage\Node\AbstractNode as Node;
use SebastianBergmann\CodeCoverage\Node\Directory as DirectoryNode;

/**
 * Renders a directory node.
 */
final class Directory extends Renderer
{
    /**
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function render(DirectoryNode $node, string $file): void
    {
        $template = new \Text_Template($this->templatePath . 'directory.html', '{{', '}}');

        $this->setCommonTemplateVariables($template, $node);

        $items = $this->renderItem($node, true);

        foreach ($node->getDirectories() as $item) {
            $items .= $this->renderItem($item);
        }

        foreach ($node->getFiles() as $item) {
            $items .= $this->renderItem($item);
        }

        $template->setVar(
            [
                'id'    => $node->getId(),
                'items' => $items,
            ]
        );

        $template->renderTo($file);
    }

    protected function renderItem(Node $node, bool $total = false): string
    {
        $data = [
            'numClasses'                   => $node->getNumClassesAndTraits(),
            'numTestedClasses'             => $node->getNumTestedClassesAndTraits(),
            'numMethods'                   => $node->getNumFunctionsAndMethods(),
            'numTestedMethods'             => $node->getNumTestedFunctionsAndMethods(),
            'linesExecutedPercent'         => $node->getLineExecutedPercent(false),
            'linesExecutedPercentAsString' => $node->getLineExecutedPercent(),
            'numExecutedLines'             => $node->getNumExecutedLines(),
            'numExecutableLines'           => $node->getNumExecutableLines(),
            'testedMethodsPercent'         => $node->getTestedFunctionsAndMethodsPercent(false),
            'testedMethodsPercentAsString' => $node->getTestedFunctionsAndMethodsPercent(),
            'testedClassesPercent'         => $node->getTestedClassesAndTraitsPercent(false),
            'testedClassesPercentAsString' => $node->getTestedClassesAndTraitsPercent(),
        ];

        if ($total) {
            $data['name'] = 'Total';
        } else {
            if ($node instanceof DirectoryNode) {
                $data['name'] = \sprintf(
                    '<a href="%s/index.html">%s</a>',
                    $node->getName(),
                    $node->getName()
                );

                $up = \str_repeat('../', \count($node->getPathAsArray()) - 2);

                $data['icon'] = \sprintf('<img src="%s_icons/file-directory.svg" class="octicon" />', $up);
            } else {
                $data['name'] = \sprintf(
                    '<a href="%s.html">%s</a>',
                    $node->getName(),
                    $node->getName()
                );

                $up = \str_repeat('../', \count($node->getPathAsArray()) - 2);

                $data['icon'] = \sprintf('<img src="%s_icons/file-code.svg" class="octicon" />', $up);
            }
        }

        return $this->renderItemTemplate(
            new \Text_Template($this->templatePath . 'directory_item.html', '{{', '}}'),
            $data
        );
    }
}
