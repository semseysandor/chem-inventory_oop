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

namespace Inventory\Core\DataBase;

use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Exception\FieldMissing;
use mysqli_result;

/**
 * Core SQL DataObject.
 *
 * @category DataBase
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class SQLDaO
{
    /**
     * DataBase Object
     *
     * @var \Inventory\Core\DataBase\SQLDataBase
     */
    protected SQLDataBase $dataBase;

    /**
     * Query string.
     *
     * @var string
     */
    protected string $query;

    /**
     * Type of query
     *
     * @var string (select|insert|update|delete)
     */
    protected string $queryType;

    /**
     * Prepared statement bind parameters.
     *
     * @var string
     */
    protected string $bind;

    /**
     * Array holding the values to insert into prepared statements.
     *
     * @var array
     */
    protected array $values;

    /**
     * Where clause.
     *
     * @var string
     */
    protected string $where;

    /**
     * From clause.
     *
     * @var string
     */
    protected string $from;

    /**
     * Join clause
     *
     * @var string
     */
    protected string $join;

    /**
     * Limit clause.
     *
     * @var string
     */
    protected string $limit;

    /**
     * Offset clause.
     *
     * @var string
     */
    protected string $offset;

    /**
     * Order by clause.
     *
     * @var string
     */
    protected string $orderBy;

    /**
     * List of fields affecting the query.
     *
     * @var array
     */
    protected array $fields;

    /**
     * Table name.
     *
     * @var string
     */
    protected string $tableName;

    /**
     * Fields metadata.
     *
     * @var array
     */
    protected array $metadata = [];

    /**
     * ID of entity
     *
     * @var int|null
     */
    public ?int $id;

    /**
     * DAO constructor.
     *
     * @param \Inventory\Core\DataBase\SQLDataBase $dataBase
     */
    public function __construct(SQLDataBase $dataBase)
    {
        $this->initQuery();
        $this->dataBase = $dataBase;
    }

    /**
     * Initializes query
     */
    protected function initQuery(): void
    {
        $this->query = '';
        $this->queryType = '';
        $this->bind = '';
        $this->values = [];
        $this->where = '';
        $this->from = '';
        $this->join = '';
        $this->limit = '';
        $this->offset = '';
        $this->orderBy = '';
        $this->fields = [];
    }

    /**
     * Get fields which are set
     *
     * @return array Fields set
     */
    protected function getFields(): array
    {
        $fields_set = [];

        // Loops through fields from metadata
        foreach ($this->metadata as $field => $meta) {
            // Dont' include id
            if ($field == 'id') {
                continue;
            }
            // If field is set --> add to selected fields
            if (isset($this->$field)) {
                $fields_set[] = $field;
            }
        }

        return $fields_set;
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * Parse parameter array
     *
     * @param array $params Parameter array
     * $params =
     *   [
     *    fields   => [field_1, field_2],
     *    where    => [
     *                 [field_1, operator1, value1],
     *                 [field_2, operator2, value2]
     *                ]
     *    limit    => 1,
     *    offset   => 25,
     *    order_by => [first_order (heh), second_order]
     *    values   => [value_1, value_2]
     *   ]
     *
     * @return $this Fluent interface
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function parseParams(array $params = null): SQLDaO
    {
        // Check argument
        if (empty($params)) {
            return $this;
        }

        // Fields
        if (array_key_exists('fields', $params) && is_array($params['fields'])) {
            $this->fields = $params['fields'];
        }

        // Joins
        if (array_key_exists('join', $params) && is_array($params['join'])) {
            foreach ($params['join'] as $joins) {
                $this->addJoin($joins[0], $joins[1]);
            }
        }

        // Where clause
        if (array_key_exists('where', $params) && is_array($params['where'])) {
            // Loop through where clauses
            foreach ($params['where'] as $where_array) {
                // Check argument
                if (!is_array($where_array) || count($where_array) < 3) {
                    continue;
                }

                // Parse where params
                $field = $where_array[0];
                $operator = $where_array[1];
                $value = $where_array[2];

                // Add where clause
                $this->addWhere($field, $operator, $value);
            }
        }

        // Limit
        if (array_key_exists('limit', $params)) {
            $this->addLimit($params['limit']);
        }

        // Offset
        if (array_key_exists('offset', $params)) {
            $this->addOffset($params['offset']);
        }

        // Order by
        if (array_key_exists('order_by', $params) && is_array($params['order_by'])) {
            $this->addOrderBy($params['order_by']);
        }

        // Values
        if (array_key_exists('values', $params) && is_array($params['values'])) {
            foreach ($params['values'] as $value) {
                $this->values[] = $value;
            }
        }

        return $this;
    }

    /**
     * Gets the bind parameter from type
     *
     * @param string $type Field type
     *
     * @return string Bind type
     */
    protected static function typeToBind(string $type): string
    {
        switch ($type) {
            case 'int':
                return 'i';
            case 'string':
                return 's';
            case 'double':
                return 'd';
            default:
                return '';
        }
    }

    /**
     * Checks if required fields are set
     *
     * @return bool
     */
    protected function checkReqFields(): bool
    {
        // Loop through fields
        foreach ($this->metadata as $field => $meta) {
            // Check if field is required
            if (isset($meta['required']) && $meta['required'] == true) {
                // If required and not set --> FAIL
                if (!isset($this->$field)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Adds metadata
     *
     * @param string $field Field name
     * @param string $type Field type (i|s|d)
     * @param string $uniq Uniq name (SQL)
     * @param string $desc Description
     * @param bool $req Is required field
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function addMetadata(string $field, string $type, string $uniq, string $desc, bool $req = false): void
    {
        // Check for field
        if (empty($field)) {
            throw new BadArgument(ts('Field missing in "%s".', $this->tableName));
        }

        // Check for metadata
        if (empty($type) || empty($uniq) || empty($desc)) {
            throw new BadArgument(ts('Metadata missing for "%s".', $field));
        }

        // Check if field already defined
        if (array_key_exists($field, $this->metadata)) {
            throw new BadArgument(ts('Metadata already defined for "%s".', $field));
        }

        // Check type
        switch ($type) {
            case 'i':
                $type = 'int';
                break;
            case 's':
                $type = 'string';
                break;
            case 'd':
                $type = 'double';
                break;
            default:
                throw new BadArgument(ts('Invalid field type for "%s". Available options: i|s|d.', $field));
        }

        // Add metadata
        $this->metadata[$field] = [
          'type' => $type,
          'uniq_name' => $uniq,
          'description' => $desc,
          'required' => $req,
        ];
    }

    /**
     * Adds parameters to bind.
     *
     * @param string $bind Bind string (int: i, string: s)
     *
     * @return $this Fluent interface
     */
    protected function bind(string $bind): SQLDaO
    {
        $this->bind .= $bind;

        return $this;
    }

    /**
     * Retrieves records from table
     *
     * @param array $params Query parameters
     * $params =
     *   [
     *    fields   => [field_1, field_2],
     *    where    => [
     *                 [field_1, operator1, value1],
     *                 [field_2, operator2, value2]
     *                ]
     *    limit    => 1,
     *    offset   => 25,
     *    order_by => [first_order (heh), second_order]
     *    values   => [value_1, value_2]
     *   ]
     *
     * @return mixed Query results
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function retrieve($params = null)
    {
        // Init select query
        $this->initSelect();

        // Parse query parameters
        $this->parseParams($params);

        // Set fields to return
        $this->setSelect($this->fields);

        // Add from clause
        $this->addFrom($this->tableName);

        // Execute query
        return $this->execute();
    }

    /**
     * Gets one record from DataBase
     *
     * @param int $id ID of the record
     * @param array|null $fields Fields to return
     *
     * @return mixed Query results
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function retrieveRecord(int $id, array $fields = null)
    {
        // Check ID
        if ($id <= 0) {
            throw new BadArgument(ts('Not valid record ID in "%s".', $this->tableName));
        }

        // Init select query
        $this->initSelect();

        // Select fields to return
        $this->setSelect($fields);

        // Add from clause
        $this->addFrom($this->tableName);

        // Add where
        $this->addWhere('id', '=', $id);

        // Execute query
        return $this->execute();
    }

    /**
     * Creates a new record
     *
     * @return mixed Query results
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     * @throws \Inventory\Core\Exception\FieldMissing
     */
    public function create()
    {
        // Checks if required fields are set
        if (!$this->checkReqFields()) {
            throw new FieldMissing(ts('Creating new record in "%s".', $this->tableName));
        }

        // Init insert query
        $this->initInsert();

        // Select fields to insert
        $this->setInsert($this->getFields());

        // Execute query
        return $this->execute();
    }

    /**
     * Updates record
     *
     * @param array $params Parameters to query
     * $params =
     *   [
     *    where => [
     *              [field_1, operator1, value1],
     *              [field_2, operator2, value2]
     *             ]
     *   ]
     *
     * @return mixed Query results
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\FieldMissing
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function update(array $params = null)
    {
        // Init update query
        $this->initUpdate();

        // Select fields to update
        $this->setUpdate($this->getFields());

        // Parse additional parameters
        $this->parseParams($params);

        // Execute query
        return $this->execute();
    }

    /**
     * Deletes records
     *
     * @param array $params Parameters to query
     * $params =
     *   [
     *    where => [
     *              [field_1, operator1, value1],
     *              [field_2, operator2, value2]
     *             ]
     *   ]
     *
     * @return mixed Query results
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function delete(array $params = null)
    {
        // Init delete query
        $this->initDelete();

        // Parse additional parameters
        $this->parseParams($params);

        // Execute query
        return $this->execute();
    }

    /**
     * Initialize a select query
     *
     * @return $this Fluent interface
     */
    public function initSelect(): SQLDaO
    {
        // Init query
        $this->initQuery();
        $this->queryType = 'select';
        $this->query = 'SELECT ';

        return $this;
    }

    /**
     * Initialize an insert query
     *
     * @return $this Fluent interface
     */
    public function initInsert(): SQLDaO
    {
        // Init query
        $this->initQuery();
        $this->queryType = 'insert';
        $this->query = "INSERT INTO {$this->tableName} ";

        return $this;
    }

    /**
     * Initialize an update query
     *
     * @return $this Fluent interface
     */
    public function initUpdate(): SQLDaO
    {
        // Init query
        $this->initQuery();
        $this->queryType = 'update';
        $this->query = "UPDATE {$this->tableName} ";

        return $this;
    }

    /**
     * Initialize a delete query
     *
     * @return $this Fluent interface
     */
    public function initDelete(): SQLDaO
    {
        // Init query
        $this->initQuery();
        $this->queryType = 'delete';
        $this->query = "DELETE FROM {$this->tableName}";

        return $this;
    }

    /**
     * Set select return fields
     *
     * @param array $fields Fields to return
     *
     * @return $this Fluent interface
     */
    public function setSelect(array $fields = null)
    {
        $field_string = '';

        if (empty($fields)) {
            // If no fields specified, then select all
            $field_string = '*';
        } else {
            // Parse fields
            foreach ($fields as $field) {
                $field_string .= ($this->metadata[$field])['uniq_name'].',';
            }
        }

        // Remove last comma
        $field_string = rtrim($field_string, ',');

        $this->query .= $field_string;

        return $this;
    }

    /**
     * Compose insert query
     *
     * @param array $fields Fields to insert
     *
     * @return $this Fluent interface
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\FieldMissing
     */
    public function setInsert(array $fields)
    {
        $column_string = '(';
        $values_string = 'VALUES (';

        if (empty($fields)) {
            throw new BadArgument(ts('No fields to insert into "%s".', $this->tableName));
        }

        // Parse fields
        foreach ($fields as $field) {
            // Compose query
            $column_string .= ($this->metadata[$field])['uniq_name'].',';
            $values_string .= '?,';

            // Prepared statement
            $this->bind(self::typeToBind($this->metadata[$field]['type']));

            // Add value if set
            if (!empty($this->$field)) {
                $this->values[] = $this->$field;
            } else {
                throw new FieldMissing(ts('Inserting into "%s".', $this->tableName));
            }
        }

        // Remove last comma
        $column_string = rtrim($column_string, ',').') ';
        $values_string = rtrim($values_string, ',').')';

        $this->query .= $column_string.$values_string;

        return $this;
    }

    /**
     * Compose update query
     *
     * @param array $fields Fields to update
     *
     * @return $this Fluent interface
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\FieldMissing
     */
    public function setUpdate(array $fields): SQLDaO
    {
        $column_string = '';

        if (empty($fields)) {
            throw new BadArgument(ts('No fields to update "%s".', $this->tableName));
        }

        // Parse fields
        foreach ($fields as $field) {
            // Compose query
            $column_string .= ($this->metadata[$field])['uniq_name'].'=?,';

            // Prepared statement
            $this->bind(self::typeToBind($this->metadata[$field]['type']));

            // Add value if set
            if (!empty($this->$field)) {
                $this->values[] = $this->$field;
            } else {
                throw new FieldMissing(ts('Updating "%s".', $this->tableName));
            }
        }

        // Remove last comma
        $column_string = rtrim($column_string, ',');

        $this->query .= "SET {$column_string}";

        return $this;
    }

    /**
     * Adds where clause
     *
     * @param string $field Concerned field
     * @param string $operator Operator
     * @param mixed $value Value for field
     *
     * @return $this Fluent interface
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function addWhere(string $field, string $operator, $value): SQLDaO
    {
        // Check arguments
        if (empty($field) || empty($operator) || empty($value)) {
            return $this;
        }

        // If there is already a where clause
        $where_string = empty($this->where) ? 'WHERE ' : ' AND ';

        // Add field
        $where_string .= $field;

        // Add operator
        switch ($operator) {
            case '=':
                $where_string .= ' = ';
                break;
            case '!=':
                $where_string .= ' != ';
                break;
            case '>':
                $where_string .= ' > ';
                break;
            case '>=':
                $where_string .= ' >= ';
                break;
            case '<':
                $where_string .= ' < ';
                break;
            case '<=':
                $where_string .= ' <= ';
                break;
            case 'like':
                $where_string .= ' LIKE ';
                break;
            default:
                throw new BadArgument(ts('Invalid operator "%s".', $operator));
                break;
        }

        // Add value
        $where_string .= $value;

        // Update where
        $this->where .= $where_string;

        return $this;
    }

    /**
     * Adds from clause.
     *
     * @param string $from From value
     *
     * @return $this Fluent interface
     */
    public function addFrom(string $from): SQLDaO
    {
        // Check argument
        if (empty($from)) {
            return $this;
        }

        // Add from clause
        $this->from .= "FROM {$from}";

        return $this;
    }

    /**
     * Adds join clause
     *
     * @param string $table Joined table
     * @param string $using Join on
     *
     * @return $this
     */
    public function addJoin(string $table, string $using): SQLDaO
    {
        if (empty($table) || empty($using)) {
            return $this;
        }

        $this->join = "INNER JOIN {$table} USING ({$using})";

        return $this;
    }

    /**
     * Adds order by clause.
     *
     * @param array $params Fields to include in order by
     *
     * @return $this Fluent interface
     */
    public function addOrderBy(array $params): SQLDaO
    {
        // Check argument
        if (empty($params)) {
            return $this;
        }

        // Check if there is already an order by clause
        $order_by = empty($this->orderBy) ? 'ORDER BY ' : ', ';

        // Add clauses
        foreach ($params as $order) {
            $order_by .= $order.',';
        }

        // Remove last comma
        $order_by = rtrim($order_by, ',');

        // Update orderBy
        $this->orderBy .= $order_by;

        return $this;
    }

    /**
     * Adds limit clause.
     *
     * @param string $limit Limit value
     *
     * @return $this Fluent interface
     */
    public function addLimit(string $limit): SQLDaO
    {
        // Check argument
        if (empty($limit)) {
            return $this;
        }

        // Add limit
        $this->limit .= "LIMIT {$limit}";

        return $this;
    }

    /**
     * Adds offset.
     *
     * @param string $offset Offset value
     *
     * @return $this Fluent interface
     */
    public function addOffset(string $offset): SQLDaO
    {
        // Check argument
        if (empty($offset)) {
            return $this;
        }

        // Add offset
        $this->offset .= "OFFSET {$offset}";

        return $this;
    }

    /**
     * Executes query.
     *
     * @return mixed Query results
     *
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function execute()
    {
        // Compose query
        switch ($this->queryType) {
            case 'select':
                if ($this->from) {
                    $this->query .= ' '.$this->from;
                }
                if ($this->join) {
                    $this->query .= ' '.$this->join;
                }
                if ($this->where) {
                    $this->query .= ' '.$this->where;
                }
                if ($this->orderBy) {
                    $this->query .= ' '.$this->orderBy;
                }
                if ($this->limit) {
                    $this->query .= ' '.$this->limit;
                }
                if ($this->offset) {
                    $this->query .= ' '.$this->offset;
                }
                break;
            case 'update':
            case 'delete':
                if ($this->where) {
                    $this->query .= ' '.$this->where;
                }
                break;
        }

        // Parameters
        $params = [
          'query' => $this->query,
          'bind' => $this->bind,
          'values' => $this->values,
        ];

        // DataBase
        if ($this->queryType == 'select') {
            return $this->dataBase->export($params);
        } else {
            return $this->dataBase->import($params);
        }
    }

    /**
     * Parse results from select query
     *
     * @param \mysqli_result $result Result from query
     *
     * @return null|array Results array
     *   Format:
     *     [ 0 =>
     *        'field_1 => row_1, field_2 => row_1,
     *       1 =>
     *        'field_1 => row_2, field_2 => row_2,
     *     ]
     */
    public function fetchResults(mysqli_result $result)
    {
        // If no rows then return null
        if ($result->num_rows < 1) {
            return null;
        }

        // Return results
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Parse results from select query
     *
     * @param \mysqli_result $result Result from query
     *
     * @return null|array Results array
     *   Format:
     *     [ fields => [field_1, field_2],
     *       rows   => [row_1, row_2]
     *     ]
     */
    public function fetchResultsTable(mysqli_result $result)
    {
        // If no rows then return null
        if ($result->num_rows < 1) {
            return null;
        }

        // Get fields
        $fields = $result->fetch_fields();
        foreach ($fields as $field) {
            $data['fields'] [] = ($field->name);
        }

        // Get results
        $data['rows'] = $result->fetch_all(MYSQLI_NUM);

        return $data;
    }

    /**
     * Parse results from select query
     *
     * @param \mysqli_result $result Result from query
     *
     * @return null|array Results array
     *   Format:
     *     [ field_1 => data_1,
     *       field_2 => data_2
     *     ]
     */
    public function fetchResultsOne(mysqli_result $result)
    {
        // If not a single row then return null
        if ($result->num_rows != 1) {
            return null;
        }

        // Return results
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data[0];
    }

    /**
     * Check if a query affecting one row was successful
     *
     * @param \mysqli_result $result Result from query
     *
     * @return bool
     */
    public function isSuccessfulOne(mysqli_result $result): bool
    {
        if ($result->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns auto-increment ID for last insert query
     *
     * @return int Last insert ID
     */
    public function getInsertID(): int
    {
        return $this->dataBase->getLastID();
    }
}
