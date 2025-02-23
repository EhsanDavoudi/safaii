<?php

namespace controllers;

class AdminManageController extends AdminController
{
    private $type = 'admin';

    public function admins()
    {
        $this->listEntities($this->type);
    }

    public function viewAdmin()
    {
        $this->viewEntity($this->type);
    }

    public function createAdmin()
    {
        // Define the fields
        $fields = ['name', 'lastname', 'username', 'email', 'password', 'permission'];

        // Define the required fields
        $requiredFields = ['username', 'email', 'password'];

        // Define the fields to check for duplicates (e.g., 'username' and 'email')
        $duplicateFields = [
            'username' => $_POST['username'],
            'email' => $_POST['email']
        ];

        // Call createEntity to insert the new admin record
        $this->createEntity($this->type, $fields, $requiredFields, $duplicateFields);
    }

    public function editAdmin()
    {
        // List of fields you want to update
        $fields = ['name', 'lastname', 'email', 'username', 'password', 'permission'];

        // List of required fields
        $requiredFields = ['name', 'lastname', 'email', 'username', 'password'];

        // List of fields to check for duplicates
        $duplicateFields = [
            'email' => $_POST['email'] ?? '',
            'username' => $_POST['username'] ?? ''
        ];

        // Call the editEntity method with required fields and duplicate checks
        $this->editEntity($this->type, $fields, $requiredFields, $duplicateFields);
    }

    public function deleteAdmin()
    {
        $this->deleteEntity($this->type);
    }
}