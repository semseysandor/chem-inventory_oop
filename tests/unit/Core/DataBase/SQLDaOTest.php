<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020                                |
 | Sandor Semsey <semseysandor@gmail.com>        |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

namespace Inventory\Test\Unit\Core\DataBase;

use Inventory\Core\DataBase\SQLDaO;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Exception\BadArgument;
use Inventory\Test\Framework\BaseTestCase;

/**
 * SQLDaOTest Class
 *
 * @covers \Inventory\Core\DataBase\SQLDaO
 *
 * @group database
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class SQLDaOTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\DataBase\SQLDaO
     */
    protected SQLDaO $sut;

    /**
     * SQLDaOTest constructor.
     *
     * @throws \ReflectionException
     */
    public function __construct()
    {
        parent::__construct();

        // Mock database
        $database = $this
          ->getMockBuilder(SQLDataBase::class)
          ->disableOriginalConstructor()
          ->onlyMethods(['import', 'export'])
          ->getMock();
        $database->method('import')->willReturnArgument(0);
        $database->method('export')->willReturnArgument(0);

        $this->sut = new SQLDaO($database);
        $this->setProtectedProperty($this->sut, 'tableName', 'test');
    }

    /**
     * Test set insert throws error on no fields
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\FieldMissing
     */
    public function testSetInsertOnNoFieldsError()
    {
        self::expectException(BadArgument::class);
        $this->sut->setInsert([]);
    }

    /**
     * Test type to bind
     *
     * @throws \ReflectionException
     */
    public function testTypeToBind()
    {
        $actual = $this->invokeProtectedMethod($this->sut, 'typeToBind', ['int']);
        self::assertSame('i', $actual);

        $actual = $this->invokeProtectedMethod($this->sut, 'typeToBind', ['string']);
        self::assertSame('s', $actual);

        $actual = $this->invokeProtectedMethod($this->sut, 'typeToBind', ['double']);
        self::assertSame('d', $actual);

        $actual = $this->invokeProtectedMethod($this->sut, 'typeToBind', ['INVALID']);
        self::assertSame('', $actual);
    }

    /**
     * Test add where with empty arguments
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testAddWhereEmptyArgumentsError()
    {
        self::assertSame($this->sut, $this->sut->addWhere('', '', null));
    }

    /**
     * Test add metadata no fields error
     *
     * @throws \ReflectionException
     */
    public function testAddMetadataNoFieldError()
    {
        self::expectException(BadArgument::class);
        $this->invokeProtectedMethod($this->sut, 'addMetadata', ['', 'type', 'name', 'desc']);
    }

    /**
     * Test add metadata missing metadata error
     *
     * @throws \ReflectionException
     */
    public function testAddMetadataNoMetadataError()
    {
        self::expectException(BadArgument::class);
        $this->invokeProtectedMethod($this->sut, 'addMetadata', ['field', '', 'name', 'desc']);
    }

    /**
     * Test add metadata field already defined error
     *
     * @throws \ReflectionException
     */
    public function testAddMetadataFieldAlreadyDefined()
    {
        self::expectException(BadArgument::class);
        $this->invokeProtectedMethod($this->sut, 'addMetadata', ['field', 'i', 'name', 'desc']);
        $this->invokeProtectedMethod($this->sut, 'addMetadata', ['field', 'i', 'name', 'desc']);
    }

    /**
     * Test add metadata invalid field type
     *
     * @throws \ReflectionException
     */
    public function testAddMetadataInvalidType()
    {
        self::expectException(BadArgument::class);
        $this->invokeProtectedMethod($this->sut, 'addMetadata', ['field', 'INVALID', 'name', 'desc']);
    }
}
