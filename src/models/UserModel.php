<?php

namespace models;
class UserModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Function to register a new user
    public function registerUser($name, $lastname, $email, $password)
    {
        $hashedPassword = strHash(strHash(strHash($password)));

        // Raw SQL query to insert user
        $registerQuery = "INSERT INTO users (name, last_name, email, password) VALUES ('$name', '$lastname', '$email', '$hashedPassword')";

        return $this->conn->query($registerQuery);
    }

    // Function to check if an email is already registered
    public function duplicateCheck($email)
    {
        // Raw SQL query to select user by email
        $duplicateQuery = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->conn->query($duplicateQuery);

        return $result->fetch_assoc(); // Returns the user record if found, or null if not
    }

    // Function to log in a user
    public function loginUser($id, $email, $password)
    {
        if (isset($id)) {
            $loginQuery = "SELECT * FROM users WHERE id = '$id'";
        } else {
            $loginQuery = "SELECT * FROM users WHERE email = '$email'";
        }

       $result = $this->conn->query($loginQuery);

        if ($user = $result->fetch_assoc()) {
            if ($password === $user['password']) {
                return $user; // Password is correct, return user data
            } else {
                return false; // Password is incorrect
            }
        } else {
            return false; // User not found
        }
    }

    public function nobTokenCheck($nobitexToken)
    {
        $state = new NobitexApi($nobitexToken);
        $isCheck = $state->profile();
        $data = json_decode($isCheck, true);
        $check = $data['status'] ?? null;
        if (!$check) {
            return false;
        } else return true;
    }

    public function nobTokenCecker()
    {
        $userIds = [];

        $nobTokenLissQuery = "SELECT id, nobitex_token FROM users WHERE nobitex_token IS NOT NULL AND nobitex_token != ''";

        $result = $this->conn->query($nobTokenLissQuery);
        $users = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($users as $user) {
            $nobitexToken = $user['nobitex_token'] ?? null;

            if ($nobitexToken && !$this->nobTokenCheck($nobitexToken)) {
                $this->deleteToken($user['id']);
            }
        }
    }

    // Function to add or update a Nobitex token for a user
    public function nobToken($id, $nobitexToken)
    {
        if ($this->nobTokenCheck($nobitexToken)) {
            $tokenQuery = "UPDATE users SET nobitex_token = '$nobitexToken' WHERE id = '$id'";
            return $this->conn->query($tokenQuery);
        } else {
            return false;
        }
    }

    public function deleteToken($id)
    {
        $deleteTokenQuery = "UPDATE users SET nobitex_token = NULL WHERE id = '$id'";

        return $this->conn->query($deleteTokenQuery);
    }

    public function userInfo($id)
    {
        $userInformationQuery = "SELECT * FROM users WHERE id = '$id'";
        $result = $this->conn->query($userInformationQuery);

        return $result->fetch_assoc();
    }

    // Function to edit user details (name, lastname, email, password, and nobitextoken)
    public function editUser($id, $newName = null, $newLastname = null, $newEmail = null, $newPassword = null)
    {
        // Sanitize ID to prevent SQL injection (basic level)
        $id = $this->conn->real_escape_string($id);
        $fieldsToUpdate = [];

        if ($newName !== null && $newName !== '') {
            $newName = $this->conn->real_escape_string($newName);
            $fieldsToUpdate[] = "name = '$newName'";
        }

        if ($newLastname !== null && $newLastname !== '') {
            $newLastname = $this->conn->real_escape_string($newLastname);
            $fieldsToUpdate[] = "last_name = '$newLastname'";
        }

        if ($newEmail !== null && $newEmail !== '') {
            $newEmail = $this->conn->real_escape_string($newEmail);
            $fieldsToUpdate[] = "email = '$newEmail'";
        }

        if ($newPassword !== null && $newPassword !== '') {
            $hashedPassword = strHash(strHash(strHash($newPassword)));
            $fieldsToUpdate[] = "password = '$hashedPassword'";
        }

        if (empty($fieldsToUpdate)) {
            return false; // No fields to update
        }

        // Construct the update query
        $updateQuery = "UPDATE users SET " . implode(', ', $fieldsToUpdate) . " WHERE id = '$id'";

        return $this->conn->query($updateQuery);
    }

    public function userFields($user_id, $news_signal, $trading_signal, $tether_amount)
    {
        // Prepare the SQL INSERT query
        $query = "INSERT INTO deals (user_id, news_signal, trading_signal, tether_amount) VALUES (?, ?, ?, ?)";

        // Prepare the statement to prevent SQL injection
        if ($stmt = $this->conn->prepare($query)) {
            // Bind parameters
            $stmt->bind_param("isss", $user_id, $news_signal, $trading_signal, $tether_amount);

            // Execute the statement
            // Return the result of the execute operation
            return $stmt->execute();
        } else {
            // Handle query error
            return false;
        }
    }


    public function getTradeData($user_id)
    {
        $query = "SELECT news_signal, trading_signal FROM deals WHERE user_id = ?";

        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            // Fetch all records
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Handle query error
            return [];
        }
    }

    /**
     * حذف فیدهای دوتایی
     * @param $user_id
     * @return bool
     */
    public function deleteTradeData($user_id)
    {
        // Prepare the SQL DELETE query
        $query = "DELETE FROM deals WHERE user_id = ?";

        // Prepare the statement to prevent SQL injection
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            // Check if the deletion was successful
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return true; // Record was successfully deleted
            } else {
                return false; // No record was deleted (perhaps no such user_id exists)
            }
        } else {
            // Handle query error
            return false;
        }
    }
}
