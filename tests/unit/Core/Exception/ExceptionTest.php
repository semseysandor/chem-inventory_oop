<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | (c) Sandor Semsey <semseysandor@gmail.com>    |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 |                                               |
 | It's a free software;)                        |
 +-----------------------------------------------+
 */

/**
 * +-----------------------------------------------+
 * | This file is part of chem-inventory.          |
 * |                                               |
 * | (c) Sandor Semsey <semseysandor@gmail.com>    |
 * | All rights reserved.                          |
 * |                                               |
 * | This work is published under the MIT License. |
 * | https://choosealicense.com/licenses/mit/      |
 * |                                               |
 * | It's a free software;)                        |
 * +-----------------------------------------------+
 */

namespace Inventory\Test\Unit\Core\Exception;

use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Exception\BaseException;
use Inventory\Core\Exception\FieldMissing;
use Inventory\Core\Exception\FileMissing;
use Inventory\Core\Exception\InvalidRequest;
use Inventory\Core\Exception\SQLException;
use Inventory\Test\Framework\BaseTestCase;

/**
 * ExceptionTest Class
 *
 * @covers \Inventory\Core\Exception\BaseException
 * @covers \Inventory\Core\Exception\BadArgument
 * @covers \Inventory\Core\Exception\FieldMissing
 * @covers \Inventory\Core\Exception\FileMissing
 * @covers \Inventory\Core\Exception\InvalidRequest
 * @covers \Inventory\Core\Exception\SQLException
 *
 * @group Exception
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class ExceptionTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\Exception\BaseException
     */
    protected BaseException $sut;

    /**
     * Test exception returns info
     *
     * @dataProvider provideException
     *
     * @param string $class Exception class
     * @param string $message Exception message
     */
    public function testExceptionReturnsInfo(string $class, string $message)
    {
        $context='test';
        $this->sut=new $class($context);

        self::assertSame($context, $this->sut->getContext());
        self::assertSame($message, $this->sut->getMessage());
    }

    /**
     * Provide child exceptions
     *
     * @return array
     */
    public function provideException()
    {
        return [
          'Bad Argument' => [BadArgument::class, BadArgument::MESSAGE],
          'FieldMissing' => [FieldMissing::class, FieldMissing::MESSAGE],
          'FileMissing' => [FileMissing::class, FileMissing::MESSAGE],
          'InvalidRequest' => [InvalidRequest::class, InvalidRequest::MESSAGE],
          'SQLException' => [SQLException::class, SQLException::MESSAGE],
        ];
    }

    /**
     * Test exception prints info
     */
    public function testExceptionPrintsInfo()
    {
        $this->sut=new BaseException('test');

        self::expectOutputRegex('/test/');
        $this->sut->print();
    }
}
