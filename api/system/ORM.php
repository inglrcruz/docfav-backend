<?php

/**
 * The ORM (Object-Relational Mapping) class for interacting with a MySQL database.
 *
 * This class provides methods for performing common database operations, such as INSERT, UPDATE, DELETE, and SELECT,
 * on specified database tables. It uses PDO to establish a database connection and execute queries.
 */

namespace System;

use PDO;

class ORM
{
    private $db;

    /**
     * Constructor for the ORM class.
     *
     * @param string $host The database host
     * @param string $username The database username
     * @param string $password The database password
     * @param string $database The database name
     */
    public function __construct($host, $username, $password, $database)
    {
        $this->db = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    }

    /**
     * Insert a new record into the specified table.
     *
     * @param string $table The table name
     * @param object $data An object containing data to be inserted
     */
    public function insert($table, $data)
    {
        $propertyArray = get_object_vars($data);
        $columns = implode(', ', array_keys($propertyArray));
        $values = implode(', ', array_fill(0, count($propertyArray), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($propertyArray));
    }

    /**
     * Update records in the specified table based on a WHERE condition.
     *
     * @param string $table The table name
     * @param object $data An object containing data to be updated
     * @param mixed $where The WHERE condition
     */
    public function update($table, $data, $where)
    {
        $set = $this->whereOrSet($data, ",");
        $where = $this->whereOrSet($where);
        $sql = "UPDATE $table SET $set WHERE $where";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    /**
     * Delete records from the specified table based on a WHERE condition.
     *
     * @param string $table The table name
     * @param mixed $where The WHERE condition
     */
    public function delete($table, $where)
    {
        $where = $this->whereOrSet($where);
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    /**
     * Find all records in the specified table that match the WHERE condition.
     *
     * @param string $table The table name
     * @param mixed $where The WHERE condition
     * @return array An array of records as associative arrays
     */
    public function findAll($table, $where = [])
    {
        $stmt = $this->find($table, $where);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Find a single record in the specified table that matches the WHERE condition.
     *
     * @param string $table The table name
     * @param mixed $where The WHERE condition
     * @return object An object representing the found record
     */
    public function findOne($table, $where = [])
    {
        $stmt = $this->find($table, $where);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Prepares a SELECT query for the specified table based on a WHERE condition.
     *
     * @param string $table The table name
     * @param mixed $where The WHERE condition
     * @return \PDOStatement The prepared statement
     */
    private function find($table, $where)
    {
        $where = $this->whereOrSet($where);
        $sql = "SELECT * FROM $table";
        if (!empty($where)) $sql .= " WHERE $where";
        return $this->db->prepare($sql);
    }

    /**
     * Constructs a WHERE clause or SET clause from an associative array.
     *
     * @param array $data An associative array of data
     * @param string $sep The separator for conditions (default is "and")
     * @return string The constructed clause
     */
    private function whereOrSet($data, $sep = "and")
    {
        if (!empty($data)) {
            $conditions = [];
            foreach ($data as $key => $value) {
                $conditions[] = "$key='$value'";
            }
            $data = implode(" $sep ", $conditions);
        }
        return $data;
    }
}
