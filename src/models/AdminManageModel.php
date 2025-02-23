<?php

namespace models;

use models\AdminModel;

class AdminManageModel extends AdminModel
{
    private $table = 'admin';

    public function getAdmins($start_limit, $results_per_page)
    {
        return $this->get($this->table, $start_limit, $results_per_page);
    }

    public function getTotalAdmins()
    {
        return $this->getTotal($this->table);
    }


    public function adminInfo()
    {
        // Check if 'id' is set in the GET request
        if (isset($_GET['id']) || isset($_SESSION['admin_id'])) {
            if ($_GET['page'] === 'profile') {
                $adminID = $this->conn->real_escape_string($_SESSION['admin_id']);
            } else {
                $adminID = $this->conn->real_escape_string($_GET['id']);
            }
            // Use the general read function to fetch the admin info
            $adminInfo = $this->read($this->table, $adminID);

            // Check if a result is found
            if ($adminInfo) {
                return $adminInfo;
            } else {
                return "<h4>No Such Admin Found</h4>";
            }
        } else {
            return "<h4>No User ID Provided</h4>";
        }
    }

    public function createAdmin($firstname, $lastname, $username, $email, $password, $permission)
    {
        // Hash the password
        $hashedPassword = strHash(strHash(strHash($password)));

        return $this->create($this->table,
            ['name', 'lastname', 'username', 'email', 'password', 'permission'],
            [$firstname, $lastname, $username, $email, $hashedPassword, $permission]);
    }

    public function editAdmin($id, $updateData = [])
    {
        // Initialize the fields to update with the data provided
        $fieldsToUpdate = [
            'name' => $updateData['name'] ?? null,
            'lastname' => $updateData['lastname'] ?? null,
            'email' => $updateData['email'] ?? null,
            'username' => $updateData['username'] ?? null,
            'permission' => $updateData['permission'] ?? null
        ];

        // Hash the password if it's provided
        if (!empty($updateData['password'])) {
            $fieldsToUpdate['password'] = strHash(strHash(strHash($updateData['password'])));
        }

        // Call the edit method with the populated fields
        return $this->edit($this->table, $id, $fieldsToUpdate);
    }


    public function deleteAdmin($id)
    {
        return $this->delete($this->table, $id);
    }
}