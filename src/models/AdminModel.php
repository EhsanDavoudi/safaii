<?php

namespace models;

class AdminModel
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    public function loginAdmin($id, $username, $password)
    {

        if (isset($id)) {
            $loginQuery = "SELECT * FROM admin WHERE id = '$id'";
        } else {
            $loginQuery = "SELECT * FROM admin WHERE username = '$username'";
        }

        $result = $this->conn->query($loginQuery);

        if ($admin = $result->fetch_assoc()) {
            if ($password === $admin['password']) {
                return $admin;
            } else {
                return false;
            }
        } else {
            return false;// User not found
        }
    }

    public function adminPermission($id)
    {
        $permQuery = "SELECT permission FROM admin WHERE id = '$id'";
        $result = $this->conn->query($permQuery);
        return $result->fetch_assoc()["permission"];
    }

    public function get($table, $start_limit, $results_per_page)
    {
        // Sanitize input to prevent SQL injection (numeric values don't need quotes)
        $start_limit = (int)$start_limit;
        $results_per_page = (int)$results_per_page;

        // Build the query
        $getQuery = "SELECT * FROM $table LIMIT $start_limit, $results_per_page";

        // Execute the query
        $result = $this->conn->query($getQuery);

        // Fetch all results as an associative array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotal($table)
    {
        // Build the query
        $query = "SELECT COUNT(id) AS total FROM $table";

        // Execute the query
        $result = $this->conn->query($query);

        // Fetch the result and return the total count
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function create($table, $tableValues, $inputValues)
    {
        // Handle empty and NULL values appropriately
        $escapedValues = array_map(fn($value) => $value === null ? 'NULL' : ($value === '' ? "''" : $this->conn->real_escape_string($value)), $inputValues);

        // Convert array of table values into a string
        $columns = implode(',', $tableValues);

        // Convert array of escaped values into a string, handling NULL correctly
        $values = implode(',', array_map(function ($value) {
            // Use quotes around non-NULL values
            return $value === 'NULL' ? $value : "'$value'";
        }, $escapedValues));

        // Build and execute the query
        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        return $this->conn->query($query);
    }

    public function edit($table, $id, $fieldsToUpdate)
    {
        // Sanitize the ID to prevent SQL injection, ensuring it's not null
        if ($id !== null) {
            $id = $this->conn->real_escape_string($id);
        }

        // Sanitize and prepare each field for update
        $updates = [];
        foreach ($fieldsToUpdate as $field => $value) {
            if ($value !== null && $value !== '') {
                // Check if the value is an array
                if (is_array($value)) {
                    $sanitizedValue = implode(',', array_map([$this->conn, 'real_escape_string'], $value));  // Convert array to string
                } else {
                    $sanitizedValue = $this->conn->real_escape_string($value);  // Sanitize the string value
                }

                $updates[] = "$field = '$sanitizedValue'";
            }
        }

        // If no fields are provided for the update, return false
        if (empty($updates)) {
            return false;
        }

        // Construct and execute the update query
        $updateQuery = "UPDATE $table SET " . implode(', ', $updates) . " WHERE id = '$id'";

        if ($this->conn->query($updateQuery)) {
            return true;
        } else {
            // Output error if the query fails
            echo "Error: " . $this->conn->error;
            return false;
        }
    }

    public function read($table, $id)
    {
        // Sanitize the ID to prevent SQL injection
        $id = $this->conn->real_escape_string($id);

        // Build the query
        $query = "SELECT * FROM $table WHERE id = '$id'";

        // Execute the query
        $result = $this->conn->query($query);

        // Fetch the result as an associative array
        return $result->fetch_assoc();
    }

    public function delete($table, $id)
    {
        // Sanitize the ID to prevent SQL injection
        $id = $this->conn->real_escape_string($id);

        // Build the delete query
        $deleteQuery = "DELETE FROM $table WHERE id = '$id'";

        // Execute the query
        return $this->conn->query($deleteQuery);
    }

    public function validateRequiredFields($data, $requiredFields)
    {
        foreach ($requiredFields as $requiredField) {
            if (empty($data[$requiredField])) {
                echo "<div class='alert alert-danger'>The {$requiredField} field is required.</div>";
                return false; // Stop if a required field is empty
            }
        }
        return true;
    }

    public function checkDuplicate($table, $fields)
    {
        // Build a condition string for the query, escaping each field's value
        $conditions = [];
        foreach ($fields as $field => $value) {
            $escapedValue = $this->conn->real_escape_string($value);
            $conditions[] = "$field = '$escapedValue'";
        }

        // Join the conditions with AND to check all fields
        $conditionString = implode(' AND ', $conditions);

        // Build the query to check if any record matches the condition
        $query = "SELECT COUNT(*) as count FROM $table WHERE $conditionString";

        // Execute the query
        $result = $this->conn->query($query);

        // Fetch the result
        $row = $result->fetch_assoc();

        // Return true if a duplicate is found, otherwise false
        return $row['count'] > 0;
    }

    /*
    public function info($table, $id, $idColumn = 'id')
    {
        // Sanitize the table name and ID to prevent SQL injection
        $table = $this->conn->real_escape_string($table);
        $id = $this->conn->real_escape_string($id);
        $idColumn = $this->conn->real_escape_string($idColumn);

        // Build the query
        $query = "SELECT * FROM $table WHERE $idColumn = '$id'";

        // Execute the query and return the result as an associative array
        $result = $this->conn->query($query);
        return $result ? $result->fetch_assoc() : null;
    }
    */
}
