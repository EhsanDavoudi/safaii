<?php

namespace models;

use models\AdminModel;

class AdminUserModel extends AdminModel
{
    private $table = 'users';

    public function getUsers($start_limit, $results_per_page)
    {
        return $this->get($this->table, $start_limit, $results_per_page);
    }

    public function getTotalUsers()
    {
        return $this->getTotal($this->table);
    }

    public function userInfo()
    {
        // Check if 'id' is set in the GET request
        if (isset($_GET['id'])) {
            // Sanitize the input to prevent SQL injection
            $userID = $this->conn->real_escape_string($_GET['id']);

            // Use the general read function to fetch the user info
            $userInfo = $this->read($this->table, $userID);

            // Check if a result is found
            if ($userInfo) {
                return $userInfo;
            } else {
                return "<h4>No Such User Found</h4>";
            }
        } else {
            return "<h4>No User ID Provided</h4>";
        }
    }

    public function createUser($name, $lastname, $email, $password, $nobitexToken, $credit)
    {
        // Ensure the credit field is a valid number or set a default value
        $credit = !empty($credit) ? $credit : '';

        // Handle optional fields (nobitexToken can be empty)
        $nobitexToken = !empty($nobitexToken) ? $nobitexToken : null;

        // Hash the password
        $hashedPassword = strHash(strHash(strHash($password)));

        return $this->create(
            $this->table,
            ['name', 'last_name', 'email', 'password', 'nobitex_token', 'credit'],
            [$name, $lastname, $email, $hashedPassword, $nobitexToken, $credit]
        );
    }

    public function editUser($id, $updateData = [])
    {
        // Initialize the fields to update with the data provided
        $fieldsToUpdate = [
            'name' => $updateData['name'] ?? null,
            'last_name' => $updateData['last_name'] ?? null,
            'email' => $updateData['email'] ?? null,
            'nobitex_token' => $updateData['nobitex_token'] ?? null,
            'credit' => $updateData['credit'] ?? null,
        ];

        // Hash the password if it's provided
        if (!empty($updateData['password'])) {
            $fieldsToUpdate['password'] = strHash(strHash(strHash($updateData['password'])));
        }

        // Call the edit method with the populated fields
        return $this->edit($this->table, $id, $fieldsToUpdate);
    }


    public function deleteUser($id)
    {
        return $this->delete($this->table, $id);
    }
}