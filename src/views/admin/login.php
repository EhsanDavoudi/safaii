<!DOCTYPE html>
<html lang="fa" dir="rtl" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>پنل مدیریت</title>
    <!--favicon-->
    <link rel="icon" href="<?=ASSET_REF?>images/trl'd-logo.png" type="image/png">
    <!-- loader-->
    <link href="<?=ASSET_REF?>css/pace.min.css" rel="stylesheet">
    <script src="<?=ASSET_REF?>js/pace.min.js"></script>

    <!--plugins-->
    <link href="<?=ASSET_REF?>plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=ASSET_REF?>plugins/metismenu/metisMenu.min.css">
    <link rel="stylesheet" type="text/css" href="<?=ASSET_REF?>plugins/metismenu/mm-vertical.css">
    <!--bootstrap css-->
    <link href="<?=ASSET_REF?>css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="<?=ASSET_REF?>css/bootstrap-extended.css" rel="stylesheet">
    <link href="<?=ASSET_REF?>sass/main.css" rel="stylesheet">
    <link href="<?=ASSET_REF?>sass/dark-theme.css" rel="stylesheet">
    <link href="<?=ASSET_REF?>sass/blue-theme.css" rel="stylesheet">
    <link href="<?=ASSET_REF?>sass/responsive.css" rel="stylesheet">

    <link rel="stylesheet" href="<?=ASSET_REF?>css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

</head>

<body>

<!--authentication-->
<div class="section-authentication-cover">
    <div class="row g-0">

        <div class="col-12 col-xl-7 col-xxl-6 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end">
            <div class="card rounded-0 mb-0 border-0 shadow-none bg-transparent bg-none">
                <div class="card-body">
                    <img src="<?=ASSET_REF?>images/auth/access-control-system-abstract-concept.png" class="img-fluid auth-img-cover-login" width="470" alt="">
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5 col-xxl-6 auth-cover-right align-items-center justify-content-center border-top border-4 border-primary border-gradient-1" style="background-color: var(--bs-body-bg);">
            <div class="card rounded-0 m-3 mb-0 border-0 shadow-none bg-none">
                <div class="card-body p-sm-5">
                    <a class="navbar-brand" href="<?= BASE_URL ?>">
                        <img src="<?=ASSET_REF?>images/trl'd-logo.png" class="img-fluid" alt="Logo" width="90"> <!-- Corrected logo name -->
                        <span class="fs-5 fw-bold">SAFAII</span>
                    </a>
                    <h4 class="fw-bold mt-4">ورود ادمین</h4>

                    <div class="form-body mt-4">
                        <form action="" method="post" class="row g-3"> <!-- Added action URL placeholder -->
                            <div class="col-12">
                                <label for="inputEmailAddress" class="form-label">نام کاربری</label>
                                <input type="text" class="form-control" id="inputEmailAddress" name="username" placeholder="نام کاربری" required>
                            </div>
                            <div class="col-12">
                                <label for="inputChoosePassword" class="form-label">رمز عبور</label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" class="form-control" id="inputChoosePassword" name="password" placeholder="رمز عبور را وارد کنید" required>
                                    <a href="javascript:;" class="input-group-text bg-transparent">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-grd-royal" name="admin-login">ورود</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!--end row-->
</div>
<!--authentication-->

<!--plugins-->
<script src="<?=ASSET_REF?>js/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            const passwordField = $('#show_hide_password input');
            const icon = $('#show_hide_password i');
            if (passwordField.attr("type") == "text") {
                passwordField.attr('type', 'password');
                icon.addClass("bi-eye-slash-fill").removeClass("bi-eye-fill");
            } else if (passwordField.attr("type") == "password") {
                passwordField.attr('type', 'text');
                icon.removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
            }
        });
    });
</script>

</body>

</html>
