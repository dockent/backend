<?php

namespace Dockent\Tests\mocks;

use Phalcon\Db\AdapterInterface;
use Phalcon\Db\Column;
use Phalcon\Db\ColumnInterface;
use Phalcon\Db\dataTypes;
use Phalcon\Db\DialectInterface;
use Phalcon\Db\IndexInterface;
use Phalcon\Db\RawValue;
use Phalcon\Db\ReferenceInterface;
use Phalcon\Db\ResultInterface;
use Phalcon\Db\sqlQuery;
use Phalcon\Db\table;
use Phalcon\Db\whereCondition;

/**
 * Class Db
 * @package Dockent\Tests\mocks
 */
class Db implements AdapterInterface
{

    /**
     * Returns the first row in a SQL query result
     *
     * @param string $sqlQuery
     * @param int $fetchMode
     * @param int $placeholders
     * @return array
     */
    public function fetchOne($sqlQuery, $fetchMode = 2, $placeholders = null)
    {
        // TODO: Implement fetchOne() method.
    }

    /**
     * Dumps the complete result of a query into an array
     *
     * @param string $sqlQuery
     * @param int $fetchMode
     * @param int $placeholders
     * @return array
     */
    public function fetchAll($sqlQuery, $fetchMode = 2, $placeholders = null)
    {
        // TODO: Implement fetchAll() method.
    }

    /**
     * Inserts data into a table using custom RDBMS SQL syntax
     *
     * @param mixed $table
     * @param array $values
     * @param mixed $fields
     * @param mixed $dataTypes
     * @param $string table
     * @param $array dataTypes
     * @return
     */
    public function insert($table, array $values, $fields = null, $dataTypes = null)
    {
        return true;
    }

    /**
     * Updates data on a table using custom RDBMS SQL syntax
     *
     * @param mixed $table
     * @param mixed $fields
     * @param mixed $values
     * @param mixed $whereCondition
     * @param mixed $dataTypes
     * @param $string whereCondition
     * @param $array dataTypes
     * @return
     */
    public function update($table, $fields, $values, $whereCondition = null, $dataTypes = null)
    {
        // TODO: Implement update() method.
    }

    /**
     * Deletes data from a table using custom RDBMS SQL syntax
     *
     * @param string $table
     * @param string $whereCondition
     * @param array $placeholders
     * @param array $dataTypes
     * @return boolean
     */
    public function delete($table, $whereCondition = null, $placeholders = null, $dataTypes = null)
    {
        return true;
    }

    /**
     * Gets a list of columns
     *
     * @param    array columnList
     * @return    string
     * @param mixed $columnList
     */
    public function getColumnList($columnList)
    {
        // TODO: Implement getColumnList() method.
    }

    /**
     * Appends a LIMIT clause to sqlQuery argument
     *
     * @param mixed $sqlQuery
     * @param mixed $number
     * @param $string sqlQuery
     * @param $int number
     * @return
     */
    public function limit($sqlQuery, $number)
    {
        // TODO: Implement limit() method.
    }

    /**
     * Generates SQL checking for the existence of a schema.table
     *
     * @param string $tableName
     * @param string $schemaName
     * @return bool
     */
    public function tableExists($tableName, $schemaName = null)
    {
        return true;
    }

    /**
     * Generates SQL checking for the existence of a schema.view
     *
     * @param string $viewName
     * @param string $schemaName
     * @return bool
     */
    public function viewExists($viewName, $schemaName = null)
    {
        // TODO: Implement viewExists() method.
    }

    /**
     * Returns a SQL modified with a FOR UPDATE clause
     *
     * @param string $sqlQuery
     * @return string
     */
    public function forUpdate($sqlQuery)
    {
        // TODO: Implement forUpdate() method.
    }

    /**
     * Returns a SQL modified with a LOCK IN SHARE MODE clause
     *
     * @param string $sqlQuery
     * @return string
     */
    public function sharedLock($sqlQuery)
    {
        // TODO: Implement sharedLock() method.
    }

    /**
     * Creates a table
     *
     * @param string $tableName
     * @param string $schemaName
     * @param array $definition
     * @return bool
     */
    public function createTable($tableName, $schemaName, array $definition)
    {
        // TODO: Implement createTable() method.
    }

    /**
     * Drops a table from a schema/database
     *
     * @param string $tableName
     * @param string $schemaName
     * @param bool $ifExists
     * @return bool
     */
    public function dropTable($tableName, $schemaName = null, $ifExists = true)
    {
        // TODO: Implement dropTable() method.
    }

    /**
     * Creates a view
     *
     * @param string $viewName
     * @param array $definition
     * @param string $schemaName
     * @return bool
     */
    public function createView($viewName, array $definition, $schemaName = null)
    {
        // TODO: Implement createView() method.
    }

    /**
     * Drops a view
     *
     * @param string $viewName
     * @param string $schemaName
     * @param bool $ifExists
     * @return bool
     */
    public function dropView($viewName, $schemaName = null, $ifExists = true)
    {
        // TODO: Implement dropView() method.
    }

    /**
     * Adds a column to a table
     *
     * @param string $tableName
     * @param string $schemaName
     * @param ColumnInterface $column
     * @return bool
     */
    public function addColumn($tableName, $schemaName, ColumnInterface $column)
    {
        // TODO: Implement addColumn() method.
    }

    /**
     * Modifies a table column based on a definition
     *
     * @param string $tableName
     * @param string $schemaName
     * @param ColumnInterface $column
     * @param ColumnInterface $currentColumn
     * @return bool
     */
    public function modifyColumn($tableName, $schemaName, ColumnInterface $column, ColumnInterface $currentColumn = null)
    {
        // TODO: Implement modifyColumn() method.
    }

    /**
     * Drops a column from a table
     *
     * @param string $tableName
     * @param string $schemaName
     * @param string $columnName
     * @return bool
     */
    public function dropColumn($tableName, $schemaName, $columnName)
    {
        // TODO: Implement dropColumn() method.
    }

    /**
     * Adds an index to a table
     *
     * @param string $tableName
     * @param string $schemaName
     * @param IndexInterface $index
     * @return bool
     */
    public function addIndex($tableName, $schemaName, IndexInterface $index)
    {
        // TODO: Implement addIndex() method.
    }

    /**
     * Drop an index from a table
     *
     * @param string $tableName
     * @param string $schemaName
     * @param string $indexName
     * @return bool
     */
    public function dropIndex($tableName, $schemaName, $indexName)
    {
        // TODO: Implement dropIndex() method.
    }

    /**
     * Adds a primary key to a table
     *
     * @param string $tableName
     * @param string $schemaName
     * @param IndexInterface $index
     * @return bool
     */
    public function addPrimaryKey($tableName, $schemaName, IndexInterface $index)
    {
        // TODO: Implement addPrimaryKey() method.
    }

    /**
     * Drops primary key from a table
     *
     * @param string $tableName
     * @param string $schemaName
     * @return bool
     */
    public function dropPrimaryKey($tableName, $schemaName)
    {
        // TODO: Implement dropPrimaryKey() method.
    }

    /**
     * Adds a foreign key to a table
     *
     * @param string $tableName
     * @param string $schemaName
     * @param ReferenceInterface $reference
     * @return bool
     */
    public function addForeignKey($tableName, $schemaName, ReferenceInterface $reference)
    {
        // TODO: Implement addForeignKey() method.
    }

    /**
     * Drops a foreign key from a table
     *
     * @param string $tableName
     * @param string $schemaName
     * @param string $referenceName
     * @return bool
     */
    public function dropForeignKey($tableName, $schemaName, $referenceName)
    {
        // TODO: Implement dropForeignKey() method.
    }

    /**
     * Returns the SQL column definition from a column
     *
     * @param ColumnInterface $column
     * @return string
     */
    public function getColumnDefinition(ColumnInterface $column)
    {
        // TODO: Implement getColumnDefinition() method.
    }

    /**
     * List all tables on a database
     *
     * @param string $schemaName
     * @return array
     */
    public function listTables($schemaName = null)
    {
        // TODO: Implement listTables() method.
    }

    /**
     * List all views on a database
     *
     * @param string $schemaName
     * @return array
     */
    public function listViews($schemaName = null)
    {
        // TODO: Implement listViews() method.
    }

    /**
     * Return descriptor used to connect to the active database
     *
     * @return array
     */
    public function getDescriptor()
    {
        // TODO: Implement getDescriptor() method.
    }

    /**
     * Gets the active connection unique identifier
     *
     * @return string
     */
    public function getConnectionId()
    {
        // TODO: Implement getConnectionId() method.
    }

    /**
     * Active SQL statement in the object
     *
     * @return string
     */
    public function getSQLStatement()
    {
        // TODO: Implement getSQLStatement() method.
    }

    /**
     * Active SQL statement in the object without replace bound parameters
     *
     * @return string
     */
    public function getRealSQLStatement()
    {
        // TODO: Implement getRealSQLStatement() method.
    }

    /**
     * Active SQL statement in the object
     *
     * @return array
     */
    public function getSQLVariables()
    {
        // TODO: Implement getSQLVariables() method.
    }

    /**
     * Active SQL statement in the object
     *
     * @return array
     */
    public function getSQLBindTypes()
    {
        // TODO: Implement getSQLBindTypes() method.
    }

    /**
     * Returns type of database system the adapter is used for
     *
     * @return string
     */
    public function getType()
    {
        // TODO: Implement getType() method.
    }

    /**
     * Returns the name of the dialect used
     *
     * @return string
     */
    public function getDialectType()
    {
        // TODO: Implement getDialectType() method.
    }

    /**
     * Returns internal dialect instance
     *
     * @return DialectInterface
     */
    public function getDialect()
    {
        // TODO: Implement getDialect() method.
    }

    /**
     * This method is automatically called in \Phalcon\Db\Adapter\Pdo constructor.
     * Call it when you need to restore a database connection
     *
     * @param array $descriptor
     * @return bool
     */
    public function connect(array $descriptor = null)
    {
        // TODO: Implement connect() method.
    }

    /**
     * Sends SQL statements to the database server returning the success state.
     * Use this method only when the SQL statement sent to the server return rows
     *
     * @param string $sqlStatement
     * @param mixed $placeholders
     * @param mixed $dataTypes
     * @return bool|ResultInterface
     */
    public function query($sqlStatement, $placeholders = null, $dataTypes = null)
    {
        // TODO: Implement query() method.
    }

    /**
     * Sends SQL statements to the database server returning the success state.
     * Use this method only when the SQL statement sent to the server doesn't return any rows
     *
     * @param string $sqlStatement
     * @param mixed $placeholders
     * @param mixed $dataTypes
     * @return bool
     */
    public function execute($sqlStatement, $placeholders = null, $dataTypes = null)
    {
        // TODO: Implement execute() method.
    }

    /**
     * Returns the number of affected rows by the last INSERT/UPDATE/DELETE reported by the database system
     *
     * @return int
     */
    public function affectedRows()
    {
        // TODO: Implement affectedRows() method.
    }

    /**
     * Closes active connection returning success. Phalcon automatically closes
     * and destroys active connections within Phalcon\Db\Pool
     *
     * @return bool
     */
    public function close()
    {
        // TODO: Implement close() method.
    }

    /**
     * Escapes a column/table/schema name
     *
     * @param string $identifier
     * @return string
     */
    public function escapeIdentifier($identifier)
    {
        return '';
    }

    /**
     * Escapes a value to avoid SQL injections
     *
     * @param string $str
     * @return string
     */
    public function escapeString($str)
    {
        // TODO: Implement escapeString() method.
    }

    /**
     * Returns insert id for the auto_increment column inserted in the last SQL statement
     *
     * @param string $sequenceName
     * @return int
     */
    public function lastInsertId($sequenceName = null)
    {
        return 1;
    }

    /**
     * Starts a transaction in the connection
     *
     * @param bool $nesting
     * @return bool
     */
    public function begin($nesting = true)
    {
        // TODO: Implement begin() method.
    }

    /**
     * Rollbacks the active transaction in the connection
     *
     * @param bool $nesting
     * @return bool
     */
    public function rollback($nesting = true)
    {
        // TODO: Implement rollback() method.
    }

    /**
     * Commits the active transaction in the connection
     *
     * @param bool $nesting
     * @return bool
     */
    public function commit($nesting = true)
    {
        // TODO: Implement commit() method.
    }

    /**
     * Checks whether connection is under database transaction
     *
     * @return bool
     */
    public function isUnderTransaction()
    {
        // TODO: Implement isUnderTransaction() method.
    }

    /**
     * Return internal PDO handler
     *
     * @return \Pdo
     */
    public function getInternalHandler()
    {
        // TODO: Implement getInternalHandler() method.
    }

    /**
     * Lists table indexes
     *
     * @param string $table
     * @param string $schema
     * @return IndexInterface[]
     */
    public function describeIndexes($table, $schema = null)
    {
        // TODO: Implement describeIndexes() method.
    }

    /**
     * Lists table references
     *
     * @param string $table
     * @param string $schema
     * @return ReferenceInterface[]
     */
    public function describeReferences($table, $schema = null)
    {
        // TODO: Implement describeReferences() method.
    }

    /**
     * Gets creation options from a table
     *
     * @param string $tableName
     * @param string $schemaName
     * @return array
     */
    public function tableOptions($tableName, $schemaName = null)
    {
        // TODO: Implement tableOptions() method.
    }

    /**
     * Check whether the database system requires an explicit value for identity columns
     *
     * @return bool
     */
    public function useExplicitIdValue()
    {
        return true;
    }

    /**
     * Return the default identity value to insert in an identity column
     *
     * @return RawValue
     */
    public function getDefaultIdValue()
    {
        return new RawValue(true);
    }

    /**
     * Check whether the database system requires a sequence to produce auto-numeric values
     *
     * @return bool
     */
    public function supportSequences()
    {
        return true;
    }

    /**
     * Creates a new savepoint
     *
     * @param string $name
     * @return bool
     */
    public function createSavepoint($name)
    {
        // TODO: Implement createSavepoint() method.
    }

    /**
     * Releases given savepoint
     *
     * @param string $name
     * @return bool
     */
    public function releaseSavepoint($name)
    {
        // TODO: Implement releaseSavepoint() method.
    }

    /**
     * Rollbacks given savepoint
     *
     * @param string $name
     * @return bool
     */
    public function rollbackSavepoint($name)
    {
        // TODO: Implement rollbackSavepoint() method.
    }

    /**
     * Set if nested transactions should use savepoints
     *
     * @param bool $nestedTransactionsWithSavepoints
     * @return AdapterInterface
     */
    public function setNestedTransactionsWithSavepoints($nestedTransactionsWithSavepoints)
    {
        // TODO: Implement setNestedTransactionsWithSavepoints() method.
    }

    /**
     * Returns if nested transactions should use savepoints
     *
     * @return bool
     */
    public function isNestedTransactionsWithSavepoints()
    {
        // TODO: Implement isNestedTransactionsWithSavepoints() method.
    }

    /**
     * Returns the savepoint name to use for nested transactions
     *
     * @return string
     */
    public function getNestedTransactionSavepointName()
    {
        // TODO: Implement getNestedTransactionSavepointName() method.
    }

    /**
     * Returns an array of Phalcon\Db\Column objects describing a table
     *
     * @param string $table
     * @param string $schema
     * @return ColumnInterface[]
     */
    public function describeColumns($table, $schema = null)
    {
        return [new class implements ColumnInterface {

            /**
             * Returns schema's table related to column
             *
             * @return string
             */
            public function getSchemaName()
            {
                // TODO: Implement getSchemaName() method.
            }

            /**
             * Returns column name
             *
             * @return string
             */
            public function getName()
            {
                return 'column';
            }

            /**
             * Returns column type
             *
             * @return int
             */
            public function getType()
            {
                return Column::TYPE_TEXT;
            }

            /**
             * Returns column type reference
             *
             * @return int
             */
            public function getTypeReference()
            {
                // TODO: Implement getTypeReference() method.
            }

            /**
             * Returns column type values
             *
             * @return int
             */
            public function getTypeValues()
            {
                // TODO: Implement getTypeValues() method.
            }

            /**
             * Returns column size
             *
             * @return int
             */
            public function getSize()
            {
                // TODO: Implement getSize() method.
            }

            /**
             * Returns column scale
             *
             * @return int
             */
            public function getScale()
            {
                // TODO: Implement getScale() method.
            }

            /**
             * Returns true if number column is unsigned
             *
             * @return boolean
             */
            public function isUnsigned()
            {
                // TODO: Implement isUnsigned() method.
            }

            /**
             * Not null
             *
             * @return boolean
             */
            public function isNotNull()
            {
                return true;
            }

            /**
             * Column is part of the primary key?
             *
             * @return boolean
             */
            public function isPrimary()
            {
                return true;
            }

            /**
             * Auto-Increment
             *
             * @return boolean
             */
            public function isAutoIncrement()
            {
                return true;
            }

            /**
             * Check whether column have an numeric type
             *
             * @return boolean
             */
            public function isNumeric()
            {
                return true;
            }

            /**
             * Check whether column have first position in table
             *
             * @return boolean
             */
            public function isFirst()
            {
                return true;
            }

            /**
             * Check whether field absolute to position in table
             *
             * @return string
             */
            public function getAfterPosition()
            {
                // TODO: Implement getAfterPosition() method.
            }

            /**
             * Returns the type of bind handling
             *
             * @return int
             */
            public function getBindType()
            {
                return Column::BIND_PARAM_STR;
            }

            /**
             * Returns default value of column
             *
             * @return int
             */
            public function getDefault()
            {
                return 1;
            }

            /**
             * Check whether column has default value
             *
             * @return bool
             */
            public function hasDefault()
            {
                // TODO: Implement hasDefault() method.
            }

            /**
             * Restores the internal state of a Phalcon\Db\Column object
             *
             * @param array $data
             * @return ColumnInterface
             */
            public static function __set_state(array $data)
            {
                // TODO: Implement __set_state() method.
            }
        }];
    }
}