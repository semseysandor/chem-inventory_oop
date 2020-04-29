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

use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Entity\Compound\DAO\Compound;
use Inventory\Test\Framework\IntegrationTestCase;

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
class DataBaseTest extends IntegrationTestCase
{
    /**
     * DataBaseTest constructor.
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function __construct()
    {
        parent::__construct();

        // Connect test DB
        $this->dataBase = new SQLDataBase($this->host, $this->port, $this->name, $this->user, $this->pass);
        $this->dataBase->connect();
    }

    /**
     * Set up
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create DAO
        $this->dao = new Compound($this->dataBase);

        // Truncate test table
        $this->dataBase->execute('TRUNCATE TABLE leltar_compound');
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
        $actual = $this->dao->retrieve(
            [
                'fields' => ['name', 'subCategory'],
                'where' => [['compound_id', '=', $id]],
            ]
        );

        $actual_assoc = $this->dao->fetchResults($actual);

        $actual = $this->dao->retrieve(
            [
                'fields' => ['name', 'subCategory'],
                'where' => [['compound_id', '=', $id]],
            ]
        );
        $actual_one = $this->dao->fetchResultsOne($actual);

        $actual = $this->dao->retrieve(
            [
                'fields' => ['name', 'subCategory'],
                'where' => [['compound_id', '=', $id]],
            ]
        );
        $actual_table = $this->dao->fetchResultsTable($actual);

        $expected_assoc = [
            0 => [
                'name' => 'testCompound',
                'sub_category_id' => '1',
            ],
        ];
        $expected_one = [
            'name' => 'testCompound',
          'sub_category_id' => '1',
        ];
        $expected_table = [
          'fields' => ['name', 'sub_category_id'],
          'rows' => [
            ['testCompound', '1'],
          ],
        ];
        self::assertSame($expected_assoc, $actual_assoc);
        self::assertSame($expected_one, $actual_one);
        self::assertSame($expected_table, $actual_table);

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
        $affected_rows = $this->dao->update(['where' => [['compound_id', '>=', '2'], ['compound_id', '<', 3]]]);
        self::assertSame(1, $affected_rows);

        // Delete all
        $affected_rows = $this->dao->delete();
        self::assertSame(3, $affected_rows);
    }
}
