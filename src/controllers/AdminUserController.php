<?php

namespace controllers;

use controllers\AdminController;

class AdminUserController extends AdminController
{
    private $type = 'user';

    public function users()
    {
        $this->listEntities($this->type);
    }

    public function viewUser()
    {
        $this->viewEntity($this->type);
    }

    public function createUser()
    {
        // Define the fields
        $fields = ['name', 'lastname', 'email', 'password', 'nobitexToken', 'credit'];

        // Define the required fields
        $requiredFields = ['name', 'lastname', 'email', 'password'];

        // Define the field to check for duplicates (e.g., 'email')
        $duplicateFields = [
            'email' => $_POST['email'] ?? '',
            'nobitex_token' => $_POST['nobitexToken'] ?? ''
        ];

        // Call createEntity to insert the new user record
        $this->createEntity($this->type, $fields, $requiredFields, $duplicateFields);
    }

    public function editUser()
    {
        // List of fields you want to update
        $fields = ['name', 'lastname', 'email', 'password', 'nobitexToken', 'credit'];

        // List of required fields (exclude optional fields like 'nobitexToken' and 'credit')
        $requiredFields = ['name', 'lastname', 'email', 'password'];

        // List of fields to check for duplicates (like 'email')
        $duplicateFields = [
            'email' => $_POST['email'] ?? '',
            'nobitex_token' => $_POST['nobitexToken'] ?? ''
        ];

        // Call the editEntity method with required fields and duplicate checks
        $this->editEntity($this->type, $fields, $requiredFields, $duplicateFields);
    }

    public function deleteUser()
    {
        $this->deleteEntity($this->type);
    }
}