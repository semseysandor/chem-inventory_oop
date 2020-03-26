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

namespace Prophecy\Exception\Prediction;

use Prophecy\Prophecy\ObjectProphecy;

class AggregateException extends \RuntimeException implements PredictionException
{
    private $exceptions = array();
    private $objectProphecy;

    public function append(PredictionException $exception)
    {
        $message = $exception->getMessage();
        $message = strtr($message, array("\n" => "\n  "))."\n";
        $message = empty($this->exceptions) ? $message : "\n" . $message;

        $this->message      = rtrim($this->message.$message);
        $this->exceptions[] = $exception;
    }

    /**
     * @return PredictionException[]
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }

    public function setObjectProphecy(ObjectProphecy $objectProphecy)
    {
        $this->objectProphecy = $objectProphecy;
    }

    /**
     * @return ObjectProphecy
     */
    public function getObjectProphecy()
    {
        return $this->objectProphecy;
    }
}
