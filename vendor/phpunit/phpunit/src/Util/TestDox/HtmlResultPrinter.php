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
namespace PHPUnit\Util\TestDox;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class HtmlResultPrinter extends ResultPrinter
{
    /**
     * @var string
     */
    private const PAGE_HEADER = <<<EOT
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Test Documentation</title>
        <style>
            body {
                text-rendering: optimizeLegibility;
                font-variant-ligatures: common-ligatures;
                font-kerning: normal;
                margin-left: 2em;
            }

            body > ul > li {
                font-family: Source Serif Pro, PT Sans, Trebuchet MS, Helvetica, Arial;
                font-size: 2em;
            }

            h2 {
                font-family: Tahoma, Helvetica, Arial;
                font-size: 3em;
            }

            ul {
                list-style: none;
                margin-bottom: 1em;
            }
        </style>
    </head>
    <body>
EOT;

    /**
     * @var string
     */
    private const CLASS_HEADER = <<<EOT

        <h2 id="%s">%s</h2>
        <ul>

EOT;

    /**
     * @var string
     */
    private const CLASS_FOOTER = <<<EOT
        </ul>
EOT;

    /**
     * @var string
     */
    private const PAGE_FOOTER = <<<EOT

    </body>
</html>
EOT;

    /**
     * Handler for 'start run' event.
     */
    protected function startRun(): void
    {
        $this->write(self::PAGE_HEADER);
    }

    /**
     * Handler for 'start class' event.
     */
    protected function startClass(string $name): void
    {
        $this->write(
            \sprintf(
                self::CLASS_HEADER,
                $name,
                $this->currentTestClassPrettified
            )
        );
    }

    /**
     * Handler for 'on test' event.
     */
    protected function onTest($name, bool $success = true): void
    {
        $this->write(
            \sprintf(
                "            <li style=\"color: %s;\">%s %s</li>\n",
                $success ? '#555753' : '#ef2929',
                $success ? '✓' : '❌',
                $name
            )
        );
    }

    /**
     * Handler for 'end class' event.
     */
    protected function endClass(string $name): void
    {
        $this->write(self::CLASS_FOOTER);
    }

    /**
     * Handler for 'end run' event.
     */
    protected function endRun(): void
    {
        $this->write(self::PAGE_FOOTER);
    }
}
