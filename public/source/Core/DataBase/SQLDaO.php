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

namespace Inventory\Core\DataBase;

use Inventory\Core\Exception\BadArgument;
use Inventory\Core\Exception\FieldMissing;
use Inventory\Core\Exception\FileMissing;
use Inventory\Core\Exception\SQLException;
use Inventory\Inv;
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
     * Query string.
     *
     * @var string
     */
    protected ?string $query;

    /**
     * Type of query
     *
     * @var string (select|insert|update|delete)
     */
    protected ?string $queryType;

    /**
     * Prepared statement bind parameters.
     *
     * @var string
     */
    protected ?string $bind;

    /**
     * Array holding the values to insert into prepared statements.
     *
     * @var array
     */
    protected ?array $values;

    /**
     * Where clause.
     *
     * @var string
     */
    protected ?string $where;

    /**
     * From clause.
     *
     * @var string
     */
    protected ?string $from;

    /**
     * Limit clause.
     *
     * @var string
     */
    protected ?string $limit;

    /**
     * Offset clause.
     *
     * @var string
     */
    protected ?string $offset;

    /**
     * Order by clause.
     *
     * @var string
     */
    protected ?string $orderBy;

    /**
     * List of fields affecting the query.
     *
     * @var array
     */
    protected ?array $fields;

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
    protected ?int $id;

    /**
     * DAO constructor.
     */
    protected function __construct()
    {
        $this->initQuery();
    }

    /**
     * Initializes query
     *
     * @return void
     */
    protected function initQuery(): void
    {
        $this->query = null;
        $this->queryType = null;
        $this->bind = null;
        $this->values = [];
        $this->where = null;
        $this->from = null;
        $this->limit = null;
        $this->offset = null;
        $this->orderBy = null;
        $this->fields = null;
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
            if (isset($this->$field)) {
                $fields_set[] = $field;
            }
        }

        return $fields_set;
    }

    /**
     * Parse parameter array
     *
     * @param array $params Parameter array
     *   $params =
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
     * @return $this
     *
     * @throws BadArgument
     */
    protected function parseParams(array $params = null): SQLDaO
    {
        // Check argument
        if ($params == null) {
            return $this;
        }

        // Fields
        if (array_key_exists('fields', $params)) {
            $this->fields = $params['fields'];
        }

        // Where clause
        if (array_key_exists('where', $params)) {
            foreach ($params['where'] as $where_array) {
                // Check argument
                if (!is_array($where_array) || count($where_array) < 3) {
                    continue;
                }

                // Parse where params
                $field = $where_array[0];
                $operator = $where_array[1];
                $value = $where_array[2];

                // Prepared statement
                if ($value === '?') {
                    $this->bind(self::typeToBind($this->metadata[$field]['type']));
                }

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
     * @return string
     *
     * @throws BadArgument
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
                throw new BadArgument(ts('Invalid field type "%s"', $type));
        }
    }

    /**
     * Checks if required fields are set
     *
     * @return bool
     */
    protected function checkReqFields(): bool
    {
        foreach ($this->metadata as $field => $meta) {
            if (isset($meta['required']) && $meta['required'] == true) {
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
     * @return void
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    protected function addMetadata(string $field, string $type, string $uniq, string $desc, bool $req = false): void
    {
        // Check for field
        if (empty($field)) {
            throw new BadArgument(ts('Field missing in "%s"', $this->tableName));
        }

        // Check for metadata
        if (empty($type) || empty($uniq) || empty($desc)) {
            throw new BadArgument(ts('Metadata missing for "%s"', $field));
        }

        // Check if field already defined
        if (array_key_exists($field, $this->metadata)) {
            throw new BadArgument(ts('Metadata already defined for "%s"', $field));
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
                throw new BadArgument(ts('Invalid field type for "%s". Available options: i|s|d', $field));
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
     * Retrieves records from table
     *
     * @param array $params Query parameters
     *
     * @return mixed
     *
     * @throws BadArgument
     * @throws SQLException
     * @throws FileMissing
     */
    public function retrieve(array $params = null)
    {
        $this->initSelect();
        $this->parseParams($params);

        $this->setSelect($this->fields);
        $this->addFrom($this->tableName);

        return $this->execute();
    }

    /**
     * Gets one record from DataBase
     *
     * @param int $id ID of the record
     * @param array|null $fields Fields to return
     *
     * @return mixed
     *
     * @throws BadArgument
     * @throws SQLException
     * @throws FileMissing
     */
    public function retrieveRecord(int $id, array $fields = null)
    {
        if ($id <= 0) {
            throw new BadArgument(ts('Not valid record ID in "%s"', $this->tableName));
        }

        $this->initSelect();
        $this->setSelect($fields);
        $this->addFrom($this->tableName);
        $this->addWhere('id', '=', $id);

        return $this->execute();
    }

    /**
     * Creates a new record
     *
     * @return mixed
     *
     * @throws BadArgument
     * @throws FieldMissing
     * @throws FileMissing
     * @throws SQLException
     */
    public function create()
    {
        // Checks if required fields are set
        if (!$this->checkReqFields()) {
            throw new FieldMissing(ts('Creating new record in "%s"', $this->tableName));
        }

        $this->initInsert();
        $this->setInsert($this->getFields());

        return $this->execute();
    }

    /**
     * Updates record
     *
     * @param array $params Parameters to query
     *
     * @return mixed
     *
     * @throws BadArgument
     * @throws FieldMissing
     * @throws SQLException
     * @throws FileMissing
     */
    public function update(array $params = null)
    {
        $this->initUpdate();
        $this->setUpdate($this->getFields());

        if (!empty($this->id) && $this->id > 0) {
            $this->addWhere('id', '=', $this->id);
        }

        $this->parseParams($params);

        return $this->execute();
    }

    /**
     * Deletes records
     *
     * @param array $params Parameters to query
     *
     * @return mixed
     *
     * @throws BadArgument
     * @throws SQLException
     * @throws FileMissing
     */
    public function delete(array $params = null)
    {
        $this->initDelete();

        if (!empty($this->id) && $this->id > 0) {
            $this->addWhere('id', '=', $this->id);
        }

        $this->parseParams($params);

        return $this->execute();
    }

    /**
     * Initialize a select query
     *
     * @return $this fluent method
     */
    public function initSelect(): SQLDaO
    {
        $this->initQuery();
        $this->queryType = 'select';
        $this->query = 'SELECT ';

        return $this;
    }

    /**
     * Initialize an insert query
     *
     * @return $this fluent method
     */
    public function initInsert(): SQLDaO
    {
        $this->initQuery();
        $this->queryType = 'insert';
        $this->query = 'INSERT INTO '.$this->tableName.' ';

        return $this;
    }

    /**
     * Initialize an update query
     *
     * @return $this fluent method
     */
    public function initUpdate(): SQLDaO
    {
        $this->initQuery();
        $this->queryType = 'update';
        $this->query = 'UPDATE '.$this->tableName.' ';

        return $this;
    }

    /**
     * Initialize a delete query
     *
     * @return $this fluent method
     */
    public function initDelete(): SQLDaO
    {
        $this->initQuery();
        $this->queryType = 'delete';
        $this->query = 'DELETE FROM '.$this->tableName.' ';

        return $this;
    }

    /**
     * Set select return fields
     *
     * @param array $fields Fields to return
     *
     * @return $this fluent method
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
        $field_string .= ' ';

        $this->query .= $field_string;

        return $this;
    }

    /**
     * Compose insert query
     *
     * @param array $fields Fields to insert
     *
     * @return $this
     *
     * @throws BadArgument
     * @throws FieldMissing
     */
    public function setInsert(array $fields)
    {
        $column_string = '(';
        $values_string = 'VALUES(';

        if (empty($fields)) {
            throw new BadArgument(ts('No fields to insert into "%s"', $this->tableName));
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
                throw new FieldMissing(ts('Inserting into "%s"', $this->tableName));
            }
        }

        if (empty($this->values)) {
            throw new BadArgument(ts('No values to insert into "%s"', $this->tableName));
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
     * @return $this fluent method
     *
     * @throws BadArgument
     * @throws FieldMissing
     */
    public function setUpdate(array $fields): SQLDaO
    {
        $column_string = '';

        if (empty($fields)) {
            throw new BadArgument(ts('No fields to update "%s"', $this->tableName));
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
                throw new FieldMissing(ts('Updating "%s"', $this->tableName));
            }
        }

        if (empty($this->values)) {
            throw new BadArgument(ts('No values to update "%s"', $this->tableName));
        }

        // Remove last comma
        $column_string = rtrim($column_string, ',');

        $this->query .= 'SET '.$column_string;

        return $this;
    }

    /**
     * Adds where clause
     *
     * @param string $field Concerned field
     * @param string $operator Operator
     * @param mixed $value Value for field
     *
     * @return $this fluent method
     *
     * @throws BadArgument
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
        if (!array_key_exists($field, $this->metadata)) {
            throw new BadArgument(ts('No such field "%s"', $field));
        }
        $where_string .= ($this->metadata[$field])['uniq_name'];

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
                throw new BadArgument(ts('Invalid operator "%s"', $this->tableName));
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
     * @return $this fluent method
     */
    public function addFrom(string $from): SQLDaO
    {
        // Check argument
        if (empty($from)) {
            return $this;
        }

        // Add from clause
        $this->from .= 'FROM '.$from;

        return $this;
    }

    /**
     * Adds order by clause.
     *
     * @param array $params
     *
     * @return $this fluent method
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
            $order_by .= ($this->metadata[$order])['uniq_name'].',';
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
     * @return $this fluent method
     */
    public function addLimit(string $limit): SQLDaO
    {
        // Check argument
        if (empty($limit)) {
            return $this;
        }

        // Add limit
        $this->limit .= 'LIMIT '.$limit;

        return $this;
    }

    /**
     * Adds offset.
     *
     * @param string $offset Offset value
     *
     * @return $this fluent method
     */
    public function addOffset(string $offset): SQLDaO
    {
        // Check argument
        if (empty($offset)) {
            return $this;
        }

        // Add offset
        $this->offset .= 'OFFSET '.$offset;

        return $this;
    }

    /**
     * Adds parameters to bind.
     *
     * @param string $bind Bind string (int: i, string: s)
     *
     * @return $this fluent method
     */
    protected function bind(string $bind): SQLDaO
    {
        $this->bind .= $bind;

        return $this;
    }

    /**
     * Executes query.
     *
     * @return mixed
     *
     * @throws SQLException
     * @throws FileMissing
     */
    public function execute()
    {
        // Compose query
        switch ($this->queryType) {
            case 'select':
                $this->query .= $this->from.' '.$this->where.' ';
                $this->query .= $this->orderBy.' '.$this->limit.' '.$this->offset;
                break;
            case 'update':
            case 'delete':
                $this->query .= ' '.$this->where;
                break;
        }

        // Parameters
        $params = [
          'query' => $this->query,
          'bind' => $this->bind,
          'values' => $this->values,
        ];

        // DataBase
        $db = Inv::database();
        if ($this->queryType == 'select') {
            return $db->export($params);
        } else {
            return $db->import($params);
        }
    }

    /**
     * Parse results from select query
     *
     * @param \mysqli_result $result Result from query
     *
     * @return null|array
     *   Format:
     *     [ fields => [field1, field2],
     *       rows   => [row1, row2]
     *     ]
     */
    public function fetchResults(mysqli_result $result)
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
     * @return int
     *
     * @throws \Inventory\Core\Exception\FileMissing
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function getInsertID(): int
    {
        return Inv::database()->getLastID();
    }
}
