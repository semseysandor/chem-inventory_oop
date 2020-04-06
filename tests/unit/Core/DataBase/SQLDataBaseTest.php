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

use Inventory\Core\DataBase\SQLDataBase;
use Inventory\Core\Exception\SQLException;
use Inventory\Test\Framework\BaseTestCase;
use Inventory\Test\Framework\HeadlessDataBaseTrait;

/**
 * SQLDataBaseTest Class
 *
 * @covers \Inventory\Core\DataBase\SQLDataBase
 *
 * @group DataBase
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class SQLDataBaseTest extends BaseTestCase
{
    use HeadlessDataBaseTrait;

    /**
     * @var \Inventory\Core\DataBase\SQLDataBase
     */
    protected SQLDataBase $sut;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new SQLDataBase($this->host, $this->port, $this->name, $this->user, $this->pass);
    }

    /**
     * Test object is initialized
     */
    public function testObjectIsInitialized()
    {
        $this->truncateTestDB();
        self::assertInstanceOf(SQLDataBase::class, $this->sut);
    }

    /**
     * Test invalid credentials
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testConnectingToInvalidDbCredentialsError()
    {
        $this->sut = new SQLDataBase('localhost', 1000, 'test', 'test', 'test');
        self::expectException(SQLException::class);
        $this->sut->connect();
    }

    /**
     * Test invalid import query
     *
     * @dataProvider provideInvalidImportQuery
     *
     * @param string $query
     * @param string $bind
     * @param array $values
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testInvalidImportAndExpectSqlError(string $query, string $bind, array $values)
    {
        $params = [
          'query' => $query,
          'bind' => $bind,
          'values' => $values,
        ];
        $this->sut->connect();
        self::expectException(SQLException::class);
        $this->sut->import($params);
    }

    /**
     * Test invalid export query
     *
     * @dataProvider provideInvalidExportQuery
     *
     * @param string $query
     * @param string $bind
     * @param array $values
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testInvalidExportAndExpectSqlError(string $query, string $bind, array $values)
    {
        $params = [
          'query' => $query,
          'bind' => $bind,
          'values' => $values,
        ];
        $this->sut->connect();
        self::expectException(SQLException::class);
        $this->sut->export($params);
    }

    /**
     * Provides invalid import queries
     *
     * @return array
     */
    public function provideInvalidImportQuery()
    {
        return [
          'SQL syntax' => [
            'INVALID',
            '',
            [],
          ],
          'Missing bind parameters' => [
            'INSERT INTO test_table (name) VALUES (?)',
            '',
            ['test'],
          ],
          'More bind parameters' => [
            'INSERT INTO test_table (name) VALUES (?)',
            'is',
            ['test'],
          ],
          'Missing values' => [
            'INSERT INTO test_table (name) VALUES (?)',
            'i',
            [],
          ],
          'More values' => [
            'INSERT INTO test_table (name) VALUES (?)',
            'i',
            [5, 'test'],
          ],
        ];
    }

    /**
     * Provides invalid export queries
     *
     * @return array
     */
    public function provideInvalidExportQuery()
    {
        return [
          'SQL syntax' => [
            'INVALID',
            '',
            [],
          ],
          'Missing bind parameters' => [
            'SELECT * FROM test_table WHERE identity > ?',
            '',
            ['test'],
          ],
          'More bind parameters' => [
            'SELECT * FROM test_table WHERE identity > ?',
            'is',
            ['test'],
          ],
          'Missing values' => [
            'SELECT * FROM test_table WHERE identity > ?',
            'i',
            [],
          ],
          'More values' => [
            'SELECT * FROM test_table WHERE identity > ?',
            'i',
            [5, 'test'],
          ],
        ];
    }

    /**
     * Test valid import query
     *
     * @dataProvider provideValidImportQuery
     *
     * @param string $query
     * @param string $bind
     * @param array $values
     * @param mixed $affected_rows
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testValidImport(string $query, string $bind, array $values, $affected_rows)
    {
        $params = [
          'query' => $query,
          'bind' => $bind,
          'values' => $values,
        ];
        $this->sut->connect();
        self::assertSame($affected_rows, $this->sut->import($params));
    }

    /**
     * Test valid export query
     *
     * @dataProvider provideValidExportQuery
     *
     * @param string $query
     * @param string $bind
     * @param array $values
     *
     * @param $expected
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testValidExport(string $query, string $bind, array $values, $expected)
    {
        $params = [
          'query' => $query,
          'bind' => $bind,
          'values' => $values,
        ];
        $this->sut->connect();
        $actual = $this->sut->export($params);

        if (is_null($expected)) {
            self::assertNull($actual);
        } else {
            self::assertSame($expected, $actual->num_rows);
        }
    }

    /**
     * Provides valid import queries
     *
     * @return array
     */
    public function provideValidImportQuery()
    {
        return [
          'Empty query' => [
            '',
            's',
            ['test'],
            null,
          ],
          'Simple query' => [
            'INSERT INTO test_table (name) VALUES (\'head\')',
            '',
            [],
            1,
          ],
          'Insert' => [
            'INSERT INTO test_table (name) VALUES (?)',
            's',
            ['test'],
            1,
          ],
          'Update record' => [
            'UPDATE test_table SET name=? WHERE test_table.id=?',
            'si',
            ['another', 1],
            1,
          ],
          'Update record to the same value' => [
            'UPDATE test_table SET name=? WHERE test_table.id=?',
            'si',
            ['another', 1],
            0,
          ],
          'Update non-existent record' => [
            'UPDATE test_table SET name=? WHERE test_table.id=?',
            'si',
            ['another', 199943],
            0,
          ],

        ];
    }

    /**
     * Provides valid export queries
     *
     * @return array
     */
    public function provideValidExportQuery()
    {
        return [
          'Empty query' => [
            '',
            'i',
            [345],
            null,
          ],
          'Prepared statement' => [
            'SELECT * FROM test_table WHERE id > ?',
            'i',
            [345],
            0,
          ],
          'Simple query' => [
            'SELECT MIN(id) FROM test_table',
            '',
            [],
            1,
          ],
        ];
    }

    /**
     * Test last insert ID
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testLastInsertId()
    {
        $this->truncateTestDB();
        $this->sut->connect();
        $params = [
          'query' => 'INSERT INTO test_table (name) VALUES (\'head\')',
        ];
        $this->sut->import($params);
        self::assertSame(1, $this->sut->getLastID());
    }
}
