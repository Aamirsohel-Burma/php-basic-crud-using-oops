<?php

class Database{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "test";
    private $conn;

    /** Connection establish automatically when constructor call */
    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    /** Create table if table is not exists */
    public function createTable($table_name, $columns)
    {
        // Generate SQL query to create table dynamically
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (";
        foreach ($columns as $column_name => $column_details) {
            $sql .= "$column_name $column_details,";
        }
        $sql = rtrim($sql, ","); // Remove the last comma from the query
        $sql .= ")";
        
        // Execute query
        if ($this->conn->query($sql) === FALSE) {
            echo "Error creating table: " . $this->conn->error;
        }
    }

    /** Insert data into database */
    public function create($table, $data)
    {
        $keys = array_keys($data);
        $values = array_map(array($this->conn, 'real_escape_string'), array_values($data));
        
        $query = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES ('" . implode("','", $values) . "')";
        if ($this->conn->query($query) === TRUE) {
            return $this->conn->insert_id;
        } else {
            return false;
        }
    }

    /** SELECT data from the table */
    public function read($table, $where = array(), $limit = '')
    {
        $query = "SELECT * FROM $table";

        if (!empty($where)) {
            $where_clause = array();
            foreach ($where as $key => $value) {
                $where_clause[] = "$key='" . $this->conn->real_escape_string($value) . "'";
            }
            $query .= ' WHERE ' . implode(' AND ', $where_clause);
        }

        if (!empty($limit)) {
            $query .= ' LIMIT ' . $limit;
        }

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return false;
        }
    }

    /** Delete data from the table */
    public function delete($table, $where)
    {
        $where_clause = array();
        foreach ($where as $key => $value) {
            $where_clause[] = "$key='" . $this->conn->real_escape_string($value) . "'";
        }
        $query = "DELETE FROM $table WHERE " . implode(' AND ', $where_clause);

        if ($this->conn->query($query) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    /** Update data of the table */
    public function update($table, $data, $where)
    {
        $set_clause = array();
        foreach ($data as $key => $value) {
            $set_clause[] = "$key='" . $this->conn->real_escape_string($value) . "'";
        }
        $where_clause = array();
        foreach ($where as $key => $value) {
            $where_clause[] = "$key='" . $this->conn->real_escape_string($value) . "'";
        }
        $query = "UPDATE $table SET " . implode(',', $set_clause) . ' WHERE ' . implode(' AND ', $where_clause);
        if ($this->conn->query($query) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}
