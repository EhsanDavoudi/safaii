<?php

namespace controllers;

use AllowDynamicProperties;
use models\UserModel;
use system\BaseController;

#[AllowDynamicProperties] class UserController extends BaseController
{
    private $validator;
    private $userModel;

    public function __construct($conn)
    {
        $this->userModel = new UserModel($conn);

        $this->validator = $this->isAuthenticated();
    }

    public function dashboard()
    {
        if (!$this->validator) {
            header("Location: ?mod=user&page=login");
            exit();
        }

        $userInformation = $this->userModel->userInfo($_SESSION['id']);
        $token = $userInformation['nobitex_token'] ?? '';

        $walletBalance = '';
        $message = '';

        if ($token && $this->userModel->nobTokenCheck($token)) {
            $walletBalance = getWalletBalance($token);
            $this->handleSettings($walletBalance);
            $this->handleTokenUpdates($token);
        } else {
            $this->handleTokenSubmission();
        }

        loadView('header', ['title' => "داشبورد", 'validator' => $this->validator]);
        loadView("dashboard", [
            'userInformation' => $userInformation,
            'message' => $message,
            'balance' => $walletBalance,
            'userSettings' => $this->userModel->getTradeData($_SESSION['id']) ?: $this->getDefaultSettings()
        ]);
        loadView("footer", ['title' => "داشبورد", 'balance' => $walletBalance]);
    }

    private function handleSettings($walletBalance)
    {
        if (isset($_POST['settings-submit'])) {
            $amount = convertToEnglishNumbers(sanitizeInput($_POST['amount'] ?? ''));

            if (filter_var($amount, FILTER_VALIDATE_FLOAT) !== false && $amount > 0 && $amount <= $walletBalance) {
                $this->saveUserSettings($amount);
                $this->setMessage('success', 'تنظیمات با موفقیت ذخیره شد.');
            } else {
                $this->setMessage('danger', 'مقدار وارد شده نامعتبر است.');
            }
        }
    }

    private function handleTokenUpdates()
    {
        if (isset($_POST["token-delete"])) {
            if ($this->userModel->deleteToken($_SESSION['id'])) {
                $this->setMessage('success', 'توکن شما حذف شد.');
            } else {
                $this->setMessage('danger', 'خطایی رخ داده.');
            }
            $this->redirectToDashboard();
        }

        if (isset($_POST["token-submit"])) {
            $newToken = sanitizeInput($_POST['nobitex-token'] ?? '');

            if ($this->userModel->nobToken($_SESSION['id'], $newToken)) {
                $this->setMessage('success', 'توکن شما با موفقیت تغییر یافت.');
            } else {
                $this->setMessage('danger', 'خطایی در ثبت توکن رخ داده است.');
                $this->userModel->deleteToken($_SESSION['id']);
            }
            $this->redirectToDashboard();
        }
    }

    private function handleTokenSubmission()
    {
        if (isset($_POST["token-submit"])) {
            $token = sanitizeInput($_POST['nobitex-token'] ?? '');

            if ($this->userModel->nobToken($_SESSION['id'], $token)) {
                $this->setMessage('success', 'توکن شما با موفقیت ثبت شد.');
            } else {
                $this->setMessage('danger', 'خطایی در ثبت توکن رخ داده است.');
            }
            $this->redirectToDashboard();
        }
    }

    private function setMessage($type, $message)
    {
        $this->message = "<div class='alert alert-$type alert-dismissible fade show'>$message
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
    }

    private function redirectToDashboard()
    {
        header("Location: ?mod=user&page=dashboard");
        exit();
    }

    public function profile()
    {
        if (!$this->validator) {
            header("Location: ?mod=user&page=login"); // Redirect to login page if not authenticated
            exit();
        }

        $userInformation = $this->userModel->userInfo($_SESSION['id']);
        $message = '';

        if (isset($_POST["edit-submit"])) {
            $firstName = sanitizeInput($_POST['firstname'] ?? '');
            $lastName = sanitizeInput($_POST['lastname'] ?? '');
            $email = sanitizeInput($_POST['email'] ?? '');
            $password = sanitizeInput($_POST['password'] ?? '');

            // Ensure that at least one field is being updated
            if ($firstName || $lastName || $email || $password) {
                if ($this->userModel->editUser($_SESSION['id'], $firstName, $lastName, $email, $password)) {
                    $message = "<div class='alert alert-success alert-dismissible fade show'>تغییرات با موفقیت ذخیره شد.
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
                } else {
                    $message = "<div class='alert alert-danger alert-dismissible fade show'>خطایی رخ داده.
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
                }
            } else {
                $message = "<div class='alert alert-warning alert-dismissible fade show'>هیچ تغییری اعمال نشد.
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
            }
            $userInformation = $this->userModel->userInfo($_SESSION['id']);
        }
        // Load the dashboard view
        loadView('header', [
            'title' => "پروفایل",
            'validator' => $this->validator
        ]);
        loadView("profile", [
            'userInformation' => $userInformation,
            'message' => $message
        ]);
        loadView("footer", [
            'title' => "پروفایل"
        ]);
    }

    public function register() {
        $message = '';

        if (isset($_POST['register-submit'])) {
            // Sanitize and validate inputs
            $firstName = sanitizeInput($_POST['firstname'] ?? '');
            $lastName = sanitizeInput($_POST['lastname'] ?? '');
            $email = sanitizeInput($_POST['email'] ?? '');
            $password = sanitizeInput($_POST['password'] ?? '');

            // Check if any of the fields are empty
            if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
                $message = "<div class='alert alert-warning alert-dismissible fade show'>لطفاً تمامی فیلدها را پر کنید.
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
            } else {
                // Check for duplicate email
                if ($this->userModel->duplicateCheck($email)) {
                    $message = "<div class='alert alert-danger alert-dismissible fade show'>ایمیل وارد شده قبلاً ثبت شده است. لطفاً از یک ایمیل دیگر استفاده کنید.
                                   <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                } else {
                    // Register the user
                    if ($this->userModel->registerUser($firstName, $lastName, $email, $password)) {
                        // Auto-login after successful registration
                        $hashedPassword = strHash(strHash($password));
                        $user = $this->userModel->loginUser(null, $email, strHash($hashedPassword)); // Fetch and verify the user
                        if ($user) {
                            // Set session variables
                            $_SESSION['id'] = $user['id'];
                            $_SESSION['password'] = $hashedPassword;

                            $message = "<div class='alert alert-success alert-dismissible fade show'>ثبت نام شما با موفقیت انجام شد.
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";

                            // Redirect to the dashboard
                            header("Location: ?mod=user&page=dashboard");
                            exit();
                        } else {
                            $message = "<div class='alert alert-danger alert-dismissible fade show'>خطا در ورود خودکار. لطفاً دوباره تلاش کنید.
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>";
                        }
                    } else {
                        $message =  "<div class='alert alert-danger alert-dismissible fade show'>خطا در ثبت نام. لطفاً دوباره تلاش کنید.
                                         <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                              </div>";
                    }
                }
            }
        }

        // Load the registration page views
        loadView('header', [
            'title' => "ثبت نام"
        ]);
        loadView("signup",[
            'message' => $message
        ]);
        loadView('footer', [
            'title' => "ثبت نام"
        ]);
    }

    public function login()
    {
        $message = '';

        if (isset($_POST['login-submit'])) {
            // Sanitize and validate inputs
            $email = sanitizeInput($_POST['email'] ?? '');
            $password = sanitizeInput($_POST['password'] ?? '');

            // Check if any of the fields are empty
            if (empty($email) || empty($password)) {
                $message = "<div class='alert alert-warning alert-dismissible fade show'>لطفاً تمامی فیلدها را پر کنید.
                               <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
            } else {
                $hashedPassword = strHash(strHash($password));
                $user = $this->userModel->loginUser(null, $email, strHash($hashedPassword));
                if ($user) {
                    // Successful login
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['password'] = $hashedPassword;

                    $message = "<div class='alert alert-success alert-dismissible fade show'>ورود شما با موفقیت انجام شد.
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";

                    // Redirect to the home page or dashboard
                    header("Location: ?mod=user&page=dashboard");
                    exit();
                } else {
                    // Invalid credentials
                    $message = "<div class='alert alert-danger alert-dismissible fade show'>ایمیل یا رمز عبور نادرست است.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                }
            }
        }
        loadView('header', [
            'title' => "ورود"
        ]);
        loadView("login", [
            'message' => $message
        ]);
        loadView('footer', [
            'title' => "ورود"
        ]);
    }

    private function saveUserSettings($amount)
    {
        $user_id = $_SESSION['id'];

        // پاک کردن داده‌های قبلی کاربر
        $this->userModel->deleteTradeData($user_id);

        $signal_percentages = $_POST['custom_signal_percentage'] ?? [];
        $trade_volumes = $_POST['custom_trade_volume'] ?? [];

        $saved_data = [];
        for ($i = 0; $i < count($signal_percentages); $i++) {
            $news_signal = sanitizeInput($signal_percentages[$i]);
            $trading_signal = sanitizeInput($trade_volumes[$i]);

            if (!empty($news_signal) && is_numeric($news_signal) &&
                !empty($trading_signal) && is_numeric($trading_signal)) {

                // بررسی برای تکراری نبودن
                $key = $news_signal . '_' . $trading_signal;
                if (!isset($saved_data[$key])) {
                    $this->userModel->userFields($user_id, $news_signal, $trading_signal, $amount);
                    $saved_data[$key] = true;
                }
            }
        }

        // اگر هیچ تنظیمی ذخیره نشد، تنظیمات پیش‌فرض را ذخیره کن
        if (empty($saved_data)) {
            $this->saveDefaultSettings($user_id, $amount);
        }
    }

    private function getDefaultSettings()
    {
        return [
            ['news_signal' => 60, 'trading_signal' => 5],
            ['news_signal' => 70, 'trading_signal' => 6],
        ];
    }

    private function saveDefaultSettings($user_id, $amount = 100)
    {
        $defaultSettings = $this->getDefaultSettings();
        foreach ($defaultSettings as $setting) {
            $this->userModel->userFields($user_id, $setting['news_signal'], $setting['trading_signal'], $amount);
        }
    }

    public function logout() {
        unset($_SESSION['id']);
        unset($_SESSION['password']);

        header("Location: ?mod=user&page=login");
        exit();
    }
}