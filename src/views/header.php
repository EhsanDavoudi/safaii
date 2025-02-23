<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>

    <link rel="icon" href="<?=ASSET_REF?>images/trl'd-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <?php
    switch ($title) {
        case 'خانه':
            echo '<link rel="stylesheet" href="../assets/css/home-style.css">';
            echo '<link rel="stylesheet" href="../assets/css/footer.css">';
            break;
        case 'ورود':
        case 'ثبت نام':
            echo '<link rel="stylesheet" href="../assets/css/login&signup-style.css">';
            break;
        case 'قیمت ارز های دیجیتال':
            echo '<link rel="stylesheet" href="../assets/css/white-header-style.css">';
            echo '<link rel="stylesheet" href="../assets/css/footer.css">';
            break;
        case 'تحلیل اخبار':
            echo '<link rel="stylesheet" href="../assets/css/blog-style.css">';
            echo '<link rel="stylesheet" href="../assets/css/white-header-style.css">';
            echo '<link rel="stylesheet" href="../assets/css/footer.css">';
            break;
        case 'داشبورد':
        case 'پروفایل':
            echo '<link rel="stylesheet" href="../assets/css/dashboard-style.css">';
            echo '<link rel="stylesheet" href="../assets/css/white-header-style.css">';
            break;
        default:
            echo '<link rel="stylesheet" href="../assets/css/singlePage-style.css">';
            echo '<link rel="stylesheet" href="../assets/css/white-header-style.css">';
            echo '<link rel="stylesheet" href="../assets/css/footer.css">';
    }
    ?>
</head>

<body>
<?php if ($title === 'خانه'):
?>
    <div class="home-section">
        <!-- Navbar Section -->
        <header class="navbar-section">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?= BASE_URL ?>"><img src="<?=ASSET_REF?>images/My%20first%20design%20(7).png" class="img-fluid" alt="Logo"></a>

                    <!-- Home Page Navigation Links -->
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    قیمت لحظه‌ای
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="?mod=currency&page=btc">بیت‌کوین</a></li>
                                    <li><a class="dropdown-item" href="?mod=currency&page=eth">اتریوم</a></li>
                                    <li><a class="dropdown-item" href="?mod=currency&page=usdt">تتر</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="?mod=home&page=table">لیست قیمت رمز ارزها</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?mod=home&page=blog">تحلیل اخبار</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">ارتباط با ما</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">درباره ما</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <?php
                                if ($validator) {
                                    // User is logged in, show dashboard link
                                    echo '<a class="btn" href="?mod=user&page=dashboard" style="padding-top: 10px;">پنل کاربری</a>';
                                } else {
                                    // User is not logged in, show login link
                                    echo '<a class="btn" href="?mod=user&page=login" style="padding-top: 10px;">پنل کاربری</a>';
                                }
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
<?php elseif ($title === 'ورود' || $title === 'ثبت نام'): ?>
    <!-- Navbar section for 'ورود' or 'ثبت نام' -->
    <header class="navbar-section">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= BASE_URL ?>">
                    <img src="<?=ASSET_REF?>images/My%20first%20design%20(7).png" class="img-fluid" alt="Logo" width="150px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>
<?php else: ?>
    <!-- Navbar section for other pages -->
    <header class="navbar-section">
        <nav class="navbar navbar-expand-lg p-0 bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= BASE_URL ?>"><img src="<?=ASSET_REF?>images/trl'd-logo.png" class="img-fluid" alt="Logo" width="75px"><span class="fw-bold">SAFAII</span></a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                قیمت لحظه‌ای
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="?mod=currency&page=btc">بیت‌کوین</a></li>
                                <li><a class="dropdown-item" href="?mod=currency&page=eth">اتریوم</a></li>
                                <li><a class="dropdown-item" href="?mod=currency&page=usdt">تتر</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="?mod=home&page=table">لیست قیمت رمز ارزها</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?mod=home&page=blog">تحلیل اخبار</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">ارتباط با ما</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">درباره ما</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <?php
                            if ($title !== 'داشبورد' && $title !== 'پروفایل') {
                                if ($validator) {
                                    // User is logged in, show dashboard link
                                    echo '<a class="btn" href="?mod=user&page=dashboard" style="padding-top: 10px;">پنل کاربری</a>';
                                } else {
                                    // User is not logged in, show login link
                                    echo '<a class="btn" href="?mod=user&page=login" style="padding-top: 10px;">پنل کاربری</a>';
                                }
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<?php endif; ?>