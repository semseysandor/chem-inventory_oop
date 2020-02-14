<?php
/**
 * This file is part of chem-inventory.
 * Written by Sandor Semsey.
 *
 * Copyright (c)  2020.
 * This is work licenced under the GNU General Public License v3.0. All rights reserved.
 *
 * This is a free software;)
 */

namespace Inventory\Core\SQL;

/**
 * Builds SQL queries
 *
 * @package Inventory\Core\SQL
 */
class QueryBuilder extends DataBase
{
    /**
     * @var string SQL query
     */
    protected $query;

    /**
     * @var string prepared statement bind parameters
     */
    protected $bind;

    /**
     * @var array values to put in prepared statements
     */
    protected $values;

    /**
     * @var bool flag (query is select or not)
     */
    protected $select;

    /**
     * DAO constructor.
     */
    public function __construct()
    {
        $this->initQuery();
        parent::__construct();
    }

    /**
     * Initializes query
     *
     * @param bool $select flag
     */
    protected function initQuery(bool $select = true)
    {
        $this->query = '';
        $this->select = $select;
        $this->bind = '';
        $this->values = [];
    }

    /**
     * Gets the query string
     *
     * @return string query
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * Adds parameters to bind
     *
     * @param string $bind
     *
     * @return $this fluent method
     */
    public function bind(string $bind): QueryBuilder
    {
        $this->bind .= $bind;

        return $this;
    }

    /**
     * Adds where clause
     *
     * @param string $where
     *
     * @return $this fluent method
     */
    public function addWhere(string $where): QueryBuilder
    {
        if ($where == null) {
            return $this;
        }
        $this->query .= ' WHERE '.$where;

        return $this;
    }

    /**
     * Adds from clause
     *
     * @param string $from
     *
     * @return $this fluent method
     */
    public function addFrom(string $from): QueryBuilder
    {
        if ($from == null) {
            return $this;
        }
        $this->query .= ' FROM '.$from;

        return $this;
    }

    /**
     * Adds order by clause
     *
     * @param string $order
     *
     * @return $this fluent method
     */
    public function addOrder(string $order): QueryBuilder
    {
        if ($order == null) {
            return $this;
        }
        $this->query .= ' ORDER BY '.$order;

        return $this;
    }

    /**
     * Adds limit clause
     *
     * @param string $limit
     *
     * @return $this fluent method
     */
    public function addLimit(string $limit): QueryBuilder
    {
        if ($limit == null) {
            return $this;
        }
        $this->query .= ' LIMIT '.$limit;

        return $this;
    }

    /**
     * Adds offset
     *
     * @param string $offset
     *
     * @return $this fluent method
     */
    public function addOffset(string $offset): QueryBuilder
    {
        if ($offset == null) {
            return $this;
        }
        $this->query .= ' OFFSET '.$offset;

        return $this;
    }

    /**
     * Executes query
     *
     * @return mixed
     * @throws \Exception
     */
    public function execute()
    {
        return $this->executeQuery($this->query, $this->select, $this->bind, $this->values);
    }

    /**
     * Makes an insert query
     *
     * @param string $table table to insert to
     * @param array $data data to insert ['field_name'=>'value']
     *
     * @return $this fluent method
     */
    public function create(string $table, array $data): QueryBuilder
    {
        $this->initQuery(false);

        $columnString = ' (';
        $valuesString = ' VALUES(';

        foreach ($data as $field => $value) {
            $columnString .= $field.',';
            $valuesString .= '?,';
            $this->values[] = $value;
        }

        $columnString = rtrim($columnString, ',').')';
        $valuesString = rtrim($valuesString, ',').')';

        $this->query = 'INSERT INTO '.$table.$columnString.$valuesString;

        return $this;
    }

    /**
     * Makes a select query
     *
     * @param array $columns column names ['col1','col2']
     *
     * @return $this fluent method
     */
    public function retrieve(array $columns): QueryBuilder
    {
        $this->initQuery();
        $columnString = '';
        foreach ($columns as $field) {
            $columnString .= $field.',';
        }
        $columnString = rtrim($columnString, ',');

        $this->query = "SELECT ".$columnString;

        return $this;
    }

    /**
     * Makes an update query
     *
     * @param string $table table to update
     * @param array $data new data ['field_name'=>'value']
     *
     * @return $this fluent method
     */
    public function update(string $table, array $data): QueryBuilder
    {
        $this->initQuery(false);

        $columnString = '';
        foreach ($data as $field => $value) {
            $columnString .= $field.'=?,';
            $this->values[] = $value;
        }
        $columnString = rtrim($columnString, ',');

        $this->query = 'UPDATE '.$table.' SET '.$columnString;

        return $this;
    }

    /**
     * Makes a delete query
     *
     * @param string $table table to delete from
     *
     * @return $this fluent method
     */
    public function delete(string $table): QueryBuilder
    {
        $this->initQuery(false);

        $this->query = 'DELETE FROM '.$table;

        return $this;
    }

}
