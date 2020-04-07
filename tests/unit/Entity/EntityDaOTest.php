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

namespace Inventory\Test\Unit\Entity;

use Inventory\Core\DataBase\SQLDaO;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Exception\FieldMissing;
use Inventory\Entity\Batch\DAO\Batch;
use Inventory\Entity\Category\DAO\Category;
use Inventory\Entity\Compound\DAO\Compound;
use Inventory\Entity\Laboratory\DAO\Laboratory;
use Inventory\Entity\Location\DAO\Location;
use Inventory\Entity\Manufacturer\DAO\Manufacturer;
use Inventory\Entity\Pack\DAO\Pack;
use Inventory\Entity\Place\DAO\Place;
use Inventory\Entity\Sub\DAO\Sub;
use Inventory\Entity\SubCategory\DAO\SubCategory;
use Inventory\Entity\User\DAO\User;
use Inventory\Test\Framework\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * EntityDaOTest Class
 *
 * @covers \Inventory\Core\DataBase\SQLDaO
 * @covers \Inventory\Entity\Batch\DAO\Batch
 * @covers \Inventory\Entity\Category\DAO\Category
 * @covers \Inventory\Entity\Compound\DAO\Compound
 * @covers \Inventory\Entity\Laboratory\DAO\Laboratory
 * @covers \Inventory\Entity\Location\DAO\Location
 * @covers \Inventory\Entity\Manufacturer\DAO\Manufacturer
 * @covers \Inventory\Entity\Pack\DAO\Pack
 * @covers \Inventory\Entity\Place\DAO\Place
 * @covers \Inventory\Entity\Sub\DAO\Sub
 * @covers \Inventory\Entity\SubCategory\DAO\SubCategory
 * @covers \Inventory\Entity\User\DAO\User
 *
 * @group database
 *
 * @category
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class EntityDaOTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\DataBase\SQLDaO
     */
    protected SQLDaO $sut;

    /**
     * Mock DataBase
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject $database;

    /**
     * Set up
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function setUp(): void
    {
        parent::setUp();

        // Mock database
        $this->database = $this
          ->getMockBuilder(SQLDataBase::class)
          ->disableOriginalConstructor()
          ->onlyMethods(['import', 'export'])
          ->getMock();
        $this->database->method('import')->willReturnArgument(0);
        $this->database->method('export')->willReturnArgument(0);

        $this->sut = new Compound($this->database);
    }

    /**
     * Test Object is Initialized
     *
     * @dataProvider provideEntityClasses
     *
     * @param string $class
     */
    public function testObjectIsInitialized(string $class)
    {
        $this->sut = new $class($this->database);
        self::assertInstanceOf($class, $this->sut);
    }

    /**
     * Provides Entity DaO classes
     *
     * @return array
     */
    public function provideEntityClasses()
    {
        return [
          'Batch' => [Batch::class],
          'Category' => [Category::class],
          'Compound' => [Compound::class],
          'Laboratory' => [Laboratory::class],
          'Location' => [Location::class],
          'Manufacturer' => [Manufacturer::class],
          'Pack' => [Pack::class],
          'Place' => [Place::class],
          'Sub' => [Sub::class],
          'SubCategory' => [SubCategory::class],
          'User' => [User::class],
        ];
    }

    /**
     * Test retrieve
     *
     * @dataProvider provideRetrieve
     *
     * @param $params
     * @param $expected
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testRetrieve($params, $expected)
    {
        $actual = $this->sut->retrieve($params);
        self::assertSame($expected, $actual['query']);
    }

    /**
     * Provides queries to retrieve
     *
     * @return array
     */
    public function provideRetrieve()
    {
        return [
          'no params' => [null, 'SELECT * FROM leltar_compound'],

          'standard' => [
            [
              'fields' => ['id', 'name'],
              'where' => [['id', '=', '?']],
              'order_by' => ['name', 'id'],
              'limit' => 10,
              'offset' => 2,
              'values' => [5],

            ],
            'SELECT compound_id,name FROM leltar_compound WHERE compound_id = ? ORDER BY name,compound_id LIMIT 10 OFFSET 2',
          ],

          'empty or missing fields' => [
            [
              'fields' => ['id', 'name'],
              'where' => [['id', '=']],
              'from' => '',
              'order_by' => [],
              'limit' => '',
              'offset' => '',
            ],
            'SELECT compound_id,name FROM leltar_compound',
          ],
        ];
    }

    /**
     * test retrieve one record
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testRetrieveOneRecord()
    {
        $actual = $this->sut->retrieveRecord(1);
        $expected = 'SELECT * FROM leltar_compound WHERE compound_id = 1';

        self::assertSame($expected, $actual['query']);
    }

    /**
     * Test retrieve one record with invalid ID
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testRetrieveOneRecordInvalidId()
    {
        self::expectException(BadArgument::class);
        $this->sut->retrieveRecord(-1);
    }

    /**
     * Test create with missing fields
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \Inventory\Core\Exception\FieldMissing
     */
    public function testCreateMissingFieldsError()
    {
        $this->expectException(FieldMissing::class);
        $this->sut->create();
    }

    /**
     * Test create with missing values
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \Inventory\Core\Exception\FieldMissing
     */
    public function testCreateMissingValues()
    {
        $this->sut->name = 'test';
        $this->sut->subCategory = 5;
        $this->sut->cas = '';

        $this->expectException(FieldMissing::class);
        $this->sut->create();
    }

    /**
     * Test create
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \Inventory\Core\Exception\FieldMissing
     */
    public function testCreate()
    {
        $this->sut->name = 'test';
        $this->sut->subCategory = 5;

        $actual = $this->sut->create();
        $expected = 'INSERT INTO leltar_compound (name,sub_category_id) VALUES (?,?)';

        self::assertSame($expected, $actual['query']);
    }

    /**
     * Test update
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \Inventory\Core\Exception\FieldMissing
     */
    public function testUpdate()
    {
        $this->sut->name = 'test';
        $this->sut->subCategory = 5;

        $actual = $this->sut->update();
        $expected = 'UPDATE leltar_compound SET name=?,sub_category_id=?';

        self::assertSame($expected, $actual['query']);
    }

    /**
     * Test update with ID
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \Inventory\Core\Exception\FieldMissing
     */
    public function testUpdateWithId()
    {
        $this->sut->name = 'test';
        $this->sut->subCategory = 5;
        $this->sut->id = 1;

        $actual = $this->sut->update();
        $expected = 'UPDATE leltar_compound SET name=?,sub_category_id=? WHERE compound_id = 1';

        self::assertSame($expected, $actual['query']);
    }

    /**
     * Test update with missing fields
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \Inventory\Core\Exception\FieldMissing
     */
    public function testUpdateMissingFieldsError()
    {
        $this->expectException(BadArgument::class);
        $this->sut->update();
    }

    /**
     * Test update with missing values
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \Inventory\Core\Exception\FieldMissing
     */
    public function testUpdateMissingValues()
    {
        $this->sut->name = 'test';
        $this->sut->subCategory = 5;
        $this->sut->cas = '';

        $this->expectException(FieldMissing::class);
        $this->sut->update();
    }

    /**
     * Test Delete
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testDelete()
    {
        $actual = $this->sut->delete();
        $expected = 'DELETE FROM leltar_compound';

        self::assertSame($expected, $actual['query']);
    }

    /**
     * Test delete with ID
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testDeleteWithId()
    {
        $this->sut->id = 1;

        $actual = $this->sut->delete();
        $expected = 'DELETE FROM leltar_compound WHERE compound_id = 1';

        self::assertSame($expected, $actual['query']);
    }

    /**
     * Test add where
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \ReflectionException
     */
    public function testAddWhere()
    {
        $this->sut->id = 1;

        $this->sut->addWhere('id', 'like', 5);
        $where = $this->getProtectedProperty($this->sut, 'where');

        self::assertSame('WHERE compound_id LIKE 5', $where);
    }

    /**
     * Test add where with invalid operator
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function testAddWhereInvalidOperatorError()
    {
        $this->sut->id = 5;

        self::expectException(BadArgument::class);
        $this->sut->addWhere('id', 'INVALID', 5);
    }
}
