<?php

namespace system;

use models\AdminModel;
use models\UserModel;

class BaseController
{
    public function isAuthenticated()
    {
        global $conn;
        $userModel = new UserModel($conn);

        if (isset($_SESSION['id']) && isset($_SESSION['password'])) {
            $id = $_SESSION['id'];
            $hashedPass = $_SESSION['password'];
            $anotherHash = strHash($hashedPass);

            if ($userModel->loginUser($id, null, $anotherHash) !== false) {
                return true;
            }
        }
        return false;
    }

    public function isAdminValid()
    {
        global $conn;
        $adminModel = new AdminModel($conn);

        $id = $_SESSION['admin_id'];
        $password = $_SESSION['admin_password'];

        // Only hash the password if it's not the plain 'admin'
        if ($password !== 'admin') {
            $password = strHash($password); // Hash the session password if it's not plain
        }

        if ($adminModel->loginAdmin($id, null, $password) !== false) {
            return true;
        }

        return false;
    }
}


