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

namespace Inventory\Test\Integration;

use Inventory\Core\DataBase\SQLDaO;
use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Entity\Compound\DAO\Compound;
use Inventory\Test\Framework\BaseTestCase;
use Inventory\Test\Framework\HeadlessDataBaseTrait;

/**
 * DataBase Integration Test Class
 *
 * @covers \Inventory\Core\DataBase\SQLDataBase
 * @covers \Inventory\Core\DataBase\SQLDaO
 * @covers \Inventory\Entity\Compound\DAO\Compound
 *
 * @group backend
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class DataBaseTest extends BaseTestCase
{
    use HeadlessDataBaseTrait;

    /**
     * DataBase
     *
     * @var \Inventory\Core\DataBase\SQLDataBase
     */
    protected SQLDataBase $dataBase;

    /**
     * DaO
     *
     * @var \Inventory\Core\DataBase\SQLDaO|\Inventory\Entity\Compound\DAO\Compound
     */
    protected SQLDaO $dao;

    /**
     * Set up
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function setUp(): void
    {
        parent::setUp();
        // Connect test DB & truncate
        $this->dataBase = new SQLDataBase($this->host, $this->port, $this->name, $this->user, $this->pass);
        $this->dataBase->connect();
        $this->truncateTestDB();

        $this->dao = new Compound($this->dataBase);
    }

    /**
     * Test insert and retrieve
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\FieldMissing
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testInsertRetrieveDelete()
    {
        // Insert
        $this->dao->name = 'testCompound';
        $this->dao->subCategory = 1;
        $affected_rows = $this->dao->create();

        self::assertSame(1, $affected_rows);

        // Check ID
        $id = $this->dao->getInsertID();
        self::assertSame(1, $id);

        // Retrieve
        $actual = $this->dao->retrieveRecord($id, ['name', 'subCategory']);
        $actual = $this->dao->fetchResults($actual);

        $expected = [
          'fields' => ['name', 'sub_category_id'],
          'rows' => [
            ['testCompound', '1'],
          ],
        ];
        self::assertSame($expected, $actual);

        // Delete one record with ID
        $this->dao->id = 1;
        $affected_rows = $this->dao->delete();
        self::assertSame(1, $affected_rows);
    }

    /**
     * Test insert update retrieve with parameters
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\FieldMissing
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testInsertUpdateRetrieveWithParameters()
    {
        // Insert
        $this->dao->name = 'test';
        $this->dao->subCategory = 2;
        $this->dao->chemFormula = 'CH4';
        $this->dao->create();
        self::assertSame(1, $this->dao->getInsertID());

        $this->dao->create();
        self::assertSame(2, $this->dao->getInsertID());

        $this->dao->create();
        self::assertSame(3, $this->dao->getInsertID());

        // Update
        $this->dao->name = 'Methane';
        $affected_rows = $this->dao->update(['where' => [['id', '>=', '2'], ['id', '<', 3]]]);
        self::assertSame(1, $affected_rows);

        // Delete all
        $affected_rows = $this->dao->delete();
        self::assertSame(3, $affected_rows);
    }
}
