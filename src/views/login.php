<div class="container">
    <?= $message ?>
    <div class="form-box box p-4">
        <h2>ورود</h2>
        <hr>
        <form action="" method="POST" class="mt-2">
            <div class="mb-2">
                <label for="emailInput" class="form-label">آدرس ایمیل</label>
                <input class="form-control" type="email" id="emailInput" name="email" placeholder="something@gmail.com" required>
            </div>

            <div class="mb-2">
                <label for="passwordInput" class="form-label">رمز عبور</label>
                <input class="form-control" type="password" id="passwordInput" name="password" placeholder="رمز عبور را وارد کنید" required>
            </div>

<!--            <div class="form-check">-->
<!--                <input type="checkbox" class="form-check-input" id="rememberMe">-->
<!--                <label class="form-check-label" for="rememberMe">مرا به خاطر بسپار</label>-->
<!--            </div>-->

            <button type="submit" name="login-submit" id="submit" class="btn btn-primary fs-4">ورود</button>
        </form>
        <div class="links">
            <p class="text-center mb-1">حساب کاربری ندارید؟ <a href="?mod=user&page=register">ثبت نام کن</a></p>
<!--            <p class="text-center"><a href="forgot.php">رمز عبور را فراموش کرده اید؟</a></p>-->
        </div>
    </div>
</div>