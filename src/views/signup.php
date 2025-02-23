<div class="container">
    <?= $message ?>
    <div class="form-box box">
        <h2>ثبت نام</h2>
        <hr>
        <form action="" method="POST" class="mt-2">
            <div class="mb-2">
                <label for="firstName" class="form-label">نام</label>
                <input class="form-control" type="text" id="firstName" name="firstname">
            </div>

            <div class="mb-2">
                <label for="lastName" class="form-label">نام خانوادگی</label>
                <input class="form-control" type="text" id="lastName" name="lastname">
            </div>

            <div class="mb-2">
                <label for="emailInput" class="form-label">آدرس ایمیل</label>
                <input class="form-control" type="email" id="emailInput" name="email" required>
            </div>

            <div class="mb-2">
                <label for="passwordInput" class="form-label">رمز عبور</label>
                <input class="form-control" type="password" id="passwordInput" name="password" required />
            </div>

            <button type="submit" name="register-submit" id="submit" class="btn btn-primary">ثبت نام</button>

            <div class="links">
                از قبل حساب کاربری دارید؟ <a href="/?mod=user&page=login">اکنون وارد شوید</a>
            </div>
        </form>
    </div>
</div>