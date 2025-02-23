<?php

namespace controllers;

use models\AdminModel;
use models\AdminManageModel;
use models\AdminUserModel;
use models\AdminDealModel;
use models\AdminNewsModel;
use system\BaseController;

class AdminController extends BaseController
{
    protected $conn;
    protected $adminModel;
    protected $adminPerm;
    protected $callModel;

    public function __construct($conn)
    {
        $this->conn = $conn;

        $this->adminModel = new AdminModel($conn);

        if (isset($_SESSION['admin_id'])) {
            $this->adminPerm = $this->adminModel->adminPermission($_SESSION['admin_id']);
        }

        if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_password'])) {
            if (!$this->isAdminValid()) {
                header("Location: ?mod=admin&page=login");
                exit();
            }
        } elseif ($_GET['page'] !== 'login') {
            header("Location: ?mod=admin&page=login");
            exit();
        }
    }

    public function login()
    {
        // If already logged in, redirect to admin dashboard
        if (isset($_SESSION['admin_id'])) {
            header("Location: ?mod=admin&page=dashboard");
            exit();
        }

        // If the login form is submitted
        if (isset($_POST["admin-login"])) {
            $username = sanitizeInput($_POST["username"] ?? '');
            $password = sanitizeInput($_POST["password"] ?? '');

            // Check if both username and password are provided
            if ($username && $password) {
                if ($password === 'admin') {
                    $admin = $this->adminModel->loginAdmin(null, $username, $password);
                    $sessionPassword = $password; // Use plain password for session
                } else {
                    $hashedPassword = strHash(strHash($password));
                    $admin = $this->adminModel->loginAdmin(null, $username, strHash($hashedPassword));
                    $sessionPassword = $hashedPassword; // Use hashed password for session
                }

                if ($admin) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_password'] = $sessionPassword;

                    header("Location: ?mod=admin&page=dashboard");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>نام کاربری یا رمز عبور نادرست است.</div>";
                }
            } else {
                echo "<div class='alert alert-warning'>لطفاً تمامی فیلدها را پر کنید.</div>";
            }
        }

        // Load the login view if no form is submitted or login failed
        loadView('admin/login');
    }

    public function dashboard()
    {
        loadView('admin/header');
        loadView('admin/sidebar', [
            'permission' => $this->adminPerm,
        ]);
//        var_dump($this->adminPerm);
        loadView('admin/dashboard');
        loadView('admin/footer');
    }

    public function profile()
    {
        $this->modelCaller('admin');

        $adminInformation = $this->callModel->adminInfo();
        $error = '';
        $success = '';

        if (isset($_POST["edit-submit"])) {
            $firstName = sanitizeInput($_POST['firstname'] ?? '');
            $lastName = sanitizeInput($_POST['lastname'] ?? '');
            $email = sanitizeInput($_POST['email'] ?? '');
            $username = sanitizeInput($_POST['username'] ?? '');
            $password = sanitizeInput($_POST['password'] ?? '');

            // Prepare the data to update
            $updateData = [
                'name' => $firstName,
                'lastname' => $lastName,
                'email' => $email,
                'username' => $username,
                'password' => $password
            ];

            // Ensure that at least one field is being updated
            if (array_filter($updateData)) {
                if ($this->callModel->editAdmin($_SESSION['admin_id'], $updateData)) {
                    $success = "<div class='alert alert-success alert-dismissible fade show'>تغییرات با موفقیت ذخیره شد.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                } else {
                    $error = "<div class='alert alert-danger alert-dismissible fade show'>خطایی رخ داده.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                }
            } else {
                $error = "<div class='alert alert-warning alert-dismissible fade show'>هیچ تغییری اعمال نشد.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
            }
            $adminInformation = $this->callModel->adminInfo();
        }

        loadView('admin/header');
        loadView('admin/sidebar', [
            'permission' => $this->adminPerm,
        ]);
        loadView("admin/profile", [
            'adminInformation' => $adminInformation,
            'error' => $error,
            'success' => $success,
        ]);
    }

    private function modelCaller($type)
    {
        switch ($type) {
            case 'admin':
                $this->callModel = new AdminManageModel($this->conn);
                break;
            case 'user':
                $this->callModel = new AdminUserModel($this->conn);
                break;
            case 'deal':
                $this->callModel = new AdminDealModel($this->conn);
                break;
            case 'news':
            case 'analyze':
            case 'blog':
                $this->callModel = new AdminNewsModel($this->conn);
                break;
        }
    }

    public function listEntities($type)
    {
        $results_per_page = 10;
        $current_page = isset($_GET['page_num']) ? max((int)$_GET['page_num'], 1) : 1;
        $start_limit = ($current_page - 1) * $results_per_page;

        // Check if the type is for nobitex token users
        if ($type === 'nobTokenList') {
            $this->modelCaller('deal');
            // Fetch the list of users with valid nobitex tokens
            $validUsers = $this->callModel->nobTokenList();

            // Paginate the results
            $total_items = count($validUsers);
            $total_pages = ceil($total_items / $results_per_page);

            // Slice the array for pagination
            $items = array_slice($validUsers, $start_limit, $results_per_page);
        } else {
            // Default dynamic call for other entity types
            $this->modelCaller($type);

            $total_items = $this->callModel->{"getTotal" . ucfirst($type) . "s"}();
            $total_pages = ceil($total_items / $results_per_page);

            $items = $this->callModel->{"get{$type}" . "s"}($start_limit, $results_per_page);
        }

        loadView('admin/header');
        loadView('admin/sidebar', [
            'permission' => $this->adminPerm,
        ]);
        loadView("admin/list", [
            "{$type}s" => $items,  // Dynamically pass the entities or users with valid tokens
            'type' => $type,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'permission' => $this->adminPerm,
        ]);
        loadView('admin/footer');
    }


    public function viewEntity($type)
    {
        $this->modelCaller($type);

        // Dynamically build the method name for retrieving the entity info (e.g., userInfo, adminInfo, etc.)
        $infoMethod = $type . "Info";

        // Check if the method exists in the model
        if (method_exists($this->callModel, $infoMethod)) {
            // Fetch the entity information using the appropriate method
            $entity = $this->callModel->{$infoMethod}();

            // Check if the entity exists
            if ($entity) {
                loadView('admin/header');
                loadView('admin/sidebar', [
                    'permission' => $this->adminPerm,
                ]);
                loadView("admin/view", [
                    "{$type}" => $entity,
                    'type'=> $type,
                    'permission' => $this->adminPerm
                ]);
                loadView('admin/footer');
            } else {
                echo "<div class='alert alert-danger'>No such {$type} found.</div>";
            }
        } else {
            // Handle the case where the method does not exist
            echo "<div class='alert alert-danger'>Method {$infoMethod} not found in the model.</div>";
        }
    }

    public function createEntity($type, $fields, $requiredFields = [], $duplicateFields = [])
    {
        $this->modelCaller($type);

        // Check if the create button for the type is set
        if (isset($_POST["create-{$type}"])) {
            // Prepare and sanitize data by trimming each POST value
            $data = array_map('trim', $_POST);

            // Validate required fields if provided
            if (!empty($requiredFields) && !$this->adminModel->validateRequiredFields($data, $requiredFields)) {
                return false; // Stop if validation fails
            }

            // Check for duplicates if fields are provided
            if (!empty($duplicateFields) && $this->adminModel->checkDuplicate($type . 's', $duplicateFields)) {
                echo "<div class='alert alert-danger'>Duplicate entry found for one of the fields.</div>";
                return false; // Stop if a duplicate is found
            }

            // Define the model's create method based on the entity type
            $createMethod = "create" . ucfirst($type);

            // Check if the corresponding model method exists
            if (method_exists($this->callModel, $createMethod)) {
                // Prepare arguments for the model method based on the provided fields
                $args = [];
                foreach ($fields as $field) {
                    // Use the value from POST data or default to an empty string
                    $args[] = $data[$field] ?? '';
                }

                // Call the model method with the prepared arguments
                $result = call_user_func_array([$this->callModel, $createMethod], $args);

                if ($result) {
                    // Redirect to the listing page for the entity type
                    header("Location: ?mod=admin&page={$type}s");
                    exit();
                } else {
                    // Handle creation failure
                    echo "<div class='alert alert-danger'>Error creating " . strtolower($type) . ".</div>";
                }
            } else {
                // Handle missing method in the model
                echo "<div class='alert alert-danger'>Method {$createMethod} not found.</div>";
            }
        }

        loadView('admin/header');
        loadView('admin/sidebar', [
            'permission' => $this->adminPerm,
        ]);
        loadView("admin/create", [
            'type' => $type,
            'permission' => $this->adminPerm
        ]);
        loadView('admin/footer');
    }

    public function editEntity($type, $fields, $requiredFields = [], $duplicateFields = [])
    {
        $this->modelCaller($type);

        $entity = [];
        $infoMethod = $type . "Info";

        if (method_exists($this->callModel, $infoMethod)) {
            $entity = $this->callModel->{$infoMethod}();

            if ($entity) {
                if (isset($_POST["edit-{$type}"])) {
                    $data = array_map('trim', $_POST);

                    // Validate required fields if provided
                    if (!empty($requiredFields) && !$this->adminModel->validateRequiredFields($data, $requiredFields)) {
                        return false; // Stop if validation fails
                    }

                    // Check for duplicates if fields are provided
                    if (!empty($duplicateFields) && $this->adminModel->checkDuplicate($type . 's', $duplicateFields)) {
                        echo "<div class='alert alert-danger'>Duplicate entry found for one of the fields.</div>";
                        return false; // Stop if a duplicate is found
                    }

                    $updateData = [];
                    foreach ($fields as $field) {
                        if (isset($data[$field]) && $data[$field] !== '') {
                            $updateData[$field] = $data[$field];
                        }
                    }

                    $editMethod = "edit" . ucfirst($type);
                    if (method_exists($this->callModel, $editMethod)) {
                        if ($this->callModel->{$editMethod}($entity['id'], $updateData)) {
                            header("Location: ?mod=admin&page={$type}s");
                            exit();
                        } else {
                            echo "<div class='alert alert-danger'>Error editing " . strtolower($type) . ".</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Edit method {$editMethod} not found.</div>";
                    }
                }
            } else {
                echo "<div class='alert alert-danger'>No such {$type} found.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Info method {$infoMethod} not found in the model.</div>";
        }

        loadView('admin/header');
        loadView('admin/sidebar', [
            'permission' => $this->adminPerm,
        ]);
        loadView("admin/edit", [
            'type' => $type,
            "{$type}" => $entity,
            'permission' => $this->adminPerm
        ]);
        loadView('admin/footer');
    }

    public function deleteEntity($type)
    {
        $this->modelCaller($type);

        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->callModel->{"delete" . ucfirst($type)}($id);
            header("Location: ?mod=admin&page={$type}s");
            exit();
        } else {
            echo "<div class='alert alert-warning'>ID not provided.</div>";
        }
    }

    public function logout()
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_password']);
        header("Location: ?mod=admin&page=login");
        exit();
    }
}