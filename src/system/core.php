<?php
require_once CONFIG_DIR . 'config.php';
require_once CONFIG_DIR . 'database.php';

require_once HELPER_DIR . 'functions.php';
require_once HELPER_DIR . 'trade.php';

require_once SYSTEM_DIR . 'BaseController.php';

require_once MODEL_DIR . 'UserModel.php';
require_once MODEL_DIR . 'NewsModel.php';
require_once MODEL_DIR . 'AdminModel.php';
require_once MODEL_DIR . 'AdminManageModel.php';
require_once MODEL_DIR . 'AdminUserModel.php';
require_once MODEL_DIR . 'AdminNewsModel.php';
require_once MODEL_DIR . 'AdminDealModel.php';
require_once MODEL_DIR . 'NobitexApi.php';

require_once CONTROLLER_DIR . 'UserController.php';
require_once CONTROLLER_DIR . 'HomeController.php';
require_once CONTROLLER_DIR . 'JobsController.php';
require_once CONTROLLER_DIR . 'AdminController.php';
require_once CONTROLLER_DIR . 'AdminManageController.php';
require_once CONTROLLER_DIR . 'AdminUserController.php';
require_once CONTROLLER_DIR . 'AdminNewsController.php';
require_once CONTROLLER_DIR . 'AdminDealController.php';

const VIEW_REF = BASE_URL . 'views' . DIRECTORY_SEPARATOR;
const ASSET_REF = BASE_URL . 'assets' . DIRECTORY_SEPARATOR;

global $conn;

use controllers\UserController;
use controllers\HomeController;
use controllers\AdminController;
use controllers\AdminManageController;
use controllers\AdminUserController;
use controllers\AdminNewsController;
use controllers\AdminDealController;

$mod = $_GET['mod'] ?? "home";
$page = $_GET['page'] ?? null;

switch ($mod) {
    case 'user':
        $userController = new UserController($conn);
        // Default to 'login' if no page is specified
        $page = $page ?? 'login';
        $userController->$page();
        break;

    case 'home':
        $homeController = new HomeController();
        // Default to 'index' if no page is specified
        $page = $page ?? 'index';
        $homeController->$page();
        break;


    case 'jobs':
        $jobsController = new \controllers\JobsController();
        // Default to 'index' if no page is specified
        $page = $page ?? 'index';
        $jobsController->$page();
        break;

    case 'currency':
        $currencyController = new HomeController();
        $currencyController->currencies($page);
        break;

    case 'admin':
        $adminController = new AdminController($conn);
        $page = $page ?? 'login'; // Default to 'dashboard' if no page is specified
        if (method_exists($adminController, $page)) {
            $adminController->$page();
        } else {
            switch ($page) {
                case 'admins':
                case 'createadmin':
                case 'viewadmin':
                case 'editadmin':
                case 'deleteadmin':
                    $class = new AdminManageController($conn);
                    $class->$page();
                    break;
                case 'users':
                case 'createuser':
                case 'viewuser':
                case 'edituser':
                case 'deleteuser':
                    $class = new AdminUserController($conn);
                    $class->$page();
                    break;
                case 'deals':
                case 'dealabeusers':
                case 'viewdeal':
                case 'editdeal':
                case 'deletedeal':
                    $class = new AdminDealController($conn);
                    $class->$page();
                    break;
                case 'news':
                case 'createnews':
                case 'viewnews':
                case 'editnews':
                case 'deletenews':
                case 'analyze':
                case 'createanalyze':
                case 'viewanalyze':
                case 'editanalyze':
                case 'deleteanalyze':
                case 'blog':
                case 'createblog':
                case 'viewblog':
                case 'editblog':
                case 'deleteblog':
                    $class = new AdminNewsController($conn);
                    $class->$page();
                    break; // Dynamically handle the page request
            }
        }
        break;

    default:
        echo "Controller not found!";
}