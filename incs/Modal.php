<?php
class Modal {
    protected $mysqli;
    protected $table;
    protected $primaryKey;

    public function __construct($table, $primaryKey = 'id') {
        $this->mysqli = $GLOBALS['conn'];
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }
    // Find all
    public function findall($where = null, $params = [], $types = '', $limit = null, $offset = null) {
        $sql = "SELECT * FROM {$this->table}";

        if (!empty($where)) {
            $sql .= " WHERE $where";
        }

        if (!empty($limit)) {
            $sql .= " LIMIT $limit";
        }

        if (!empty($offset)) {
            $sql .= " OFFSET $offset";
        }

        $stmt = $this->mysqli->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative arrays
    }

    // Create a record
    public function create($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $types = str_repeat('s', count($data)); // Assuming all fields are strings. Adjust if needed.

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param($types, ...array_values($data));
        return $stmt->execute();
    }

    // Read a record by primary key
    public function read($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $id); // Assuming primary key is an integer. Adjust if needed.
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update a record
    public function update($id, $data) {
        // Generate the SET part of the SQL query
        $set = implode(", ", array_map(fn($key) => "$key = ?", array_keys($data)));

        // Determine the types of parameters
        $types = str_repeat('s', count($data)); // Assuming all fields are strings. Adjust if needed.

        // Create the SQL query
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = ?";

        // Prepare the SQL statement
        $stmt = $this->mysqli->prepare($sql);

        // Combine the data and ID into one array
        $params = array_merge(array_values($data), [$id]);

        // Create a string with the types, including 'i' for the ID
        $types .= 'i';

        // Bind parameters to the SQL statement
        $stmt->bind_param($types, ...$params);

        // Execute the statement
        return $stmt->execute();
    }

    // Delete a record
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $id); // Assuming primary key is an integer. Adjust if needed.
        return $stmt->execute();
    }

    // Execute custom queries
    public function query($sql, $params = [], $types = '') {
        $stmt = $this->mysqli->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result();
    }
}
