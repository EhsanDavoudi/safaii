<main class="main-wrapper">
    <div class="main-content">
<?php if ($type === 'user' && ($permission === 'A' || $permission === 'B')): ?>
        <div class="col-md-12">
            <h1>اطلاعات کاربر</h1>
            <a href="?mod=admin&page=users" class="btn btn-primary float-end my-2">بازگشت</a>
            <div class="mb-3">
                <label for="firstName" class="form-label">نام</label>
                    <input id="firstName" name="firstname" class="form-control" type="text" value="<?= $user['name']; ?>" aria-label="readonly input example" readonly>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">نام خانوادگی</label>
                <input id="lastName" name="lastname" class="form-control" type="text" value="<?= $user['last_name']; ?>" aria-label="readonly input example" readonly>
            </div>
            <div class="mb-3">
                <label for="emailInput" class="form-label">آدرس ایمیل</label>
                <input id="emailInput" name="email" class="form-control" type="email" value="<?= $user['email']; ?>" aria-label="readonly input example" readonly>
            </div>
            <div class="mb-3">
                <label for="passwordInput" class="form-label">رمز عبور جدید</label>
                <input id="passwordInput" name="password" class="form-control" type="password" value="<?= $user['password']; ?>" aria-label="readonly input example" readonly>
            </div>
            <div class="mb-3">
                <label for="tokenInput" class="form-label">توکن نوبیتکس</label>
                <input class="form-control" type="text" id="tokenInput" name="nobitex-token" value="<?= $user['nobitex_token']; ?>" aria-label="readonly input example" readonly>
            </div>
            <div class="mb-3">
                <label for="creditInput" class="form-label">اعتبار</label>
                <input class="form-control" type="number" id="creditInput" name="credit" value="<?= $user['credit']; ?>" aria-label="readonly input example" readonly>
            </div>
        </div>
<?php elseif ($type === 'admin' && $permission === 'A'): ?>
    <div class="col-md-12">
        <h1>اطلاعات ادمین</h1>
        <a href="?mod=admin&page=admins" class="btn btn-primary float-end my-2">بازگشت</a>

        <div class="mb-3">
            <label for="firstName" class="form-label">نام</label>
            <input id="firstName" name="name" class="form-control" type="text" value="<?= $admin['name']; ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="lastName" class="form-label">نام خانوادگی</label>
            <input id="lastName" name="lastname" class="form-control" type="text" value="<?= $admin['lastname']; ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="emailInput" class="form-label">آدرس ایمیل</label>
            <input id="emailInput" name="email" class="form-control" type="email" value="<?= $admin['email']; ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="usernameInput" class="form-label">نام کاربری</label>
            <input id="usernameInput" name="username" class="form-control" type="text" value="<?= $admin['username']; ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="permissionInput" class="form-label">سطح دسترسی</label>
            <input id="permissionInput" name="permission" class="form-control" type="text" value="<?= $admin['permission'] === 'A' ? 'Admin' : ($admin['permission'] === 'B' ? 'User' : 'Custom Role'); ?>" readonly>
        </div>
    </div>
<?php elseif ($type === 'deal' && ($permission === 'A' || $permission === 'B')): ?>
    <div class="col-md-12">
        <h1>اطلاعات معامله</h1>
        <a href="?mod=admin&page=deals" class="btn btn-primary float-end my-2">بازگشت</a>
        <div class="mb-3">
            <label for="newsSignalInput" class="form-label">سیگنال خبری</label>
            <input id="newsSignalInput" name="newsSignal" class="form-control" type="text" value="<?= $deal['news_signal']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="tradingSignalInput" class="form-label">سیگنال معاملاتی</label>
            <input id="tradingSignalInput" name="tradingSignal" class="form-control" type="text" value="<?= $deal['trading_signal']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="tetherAmountInput" class="form-label">مقدار تتر</label>
            <input id="tetherAmountInput" name="tetherAmount" class="form-control" type="number" value="<?= $deal['tether_amount']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="statusInput" class="form-label">وضعیت</label>
            <input id="statusInput" name="status" class="form-control" type="text" value="<?= $deal['status']; ?>" readonly>
        </div>
    </div>
<?php elseif ($type === 'news' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="col-md-12">
        <h1>اطلاعات خبر</h1>
        <a href="?mod=admin&page=news" class="btn btn-primary float-end my-2">بازگشت</a>
        <div class="mb-3">
            <label for="titleInput" class="form-label">عنوان</label>
            <input id="titleInput" name="title" class="form-control" type="text" value="<?= $news['title']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="dateInput" class="form-label">تاریخ</label>
            <input id="dateInput" name="date" class="form-control" type="date" value="<?= $news['date']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="linkInput" class="form-label">لینک</label>
            <input id="linkInput" name="link" class="form-control" type="text" value="<?= $news['link']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="articleTextInput" class="form-label">متن مقاله</label>
            <textarea id="articleTextInput" name="articleText" class="form-control" rows="4" readonly><?= $news['article_text']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="translatedTitleInput" class="form-label">عنوان ترجمه‌شده</label>
            <input id="translatedTitleInput" name="translatedTitle" class="form-control" type="text" value="<?= $news['translated_title']; ?>" readonly>
        </div>
    </div>
<?php elseif($type === 'analyze' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="col-md-12">
        <h1>اطلاعات تحلیل</h1>
        <a href="?mod=admin&page=analyzes" class="btn btn-primary float-end my-2">بازگشت</a>
        <div class="mb-3">
            <label for="titleInput" class="form-label">عنوان</label>
            <input id="titleInput" name="title" class="form-control" type="text" value="<?= $analyse['title']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="symbolInput" class="form-label">نماد</label>
            <input id="symbolInput" name="symbol" class="form-control" type="text" value="<?= $analyse['symbol']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="sentimentInput" class="form-label">احساسات</label>
            <input id="sentimentInput" name="sentiment" class="form-control" type="text" value="<?= $analyse['sentiment']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="confidenceInput" class="form-label">میزان اطمینان</label>
            <input id="confidenceInput" name="confidence" class="form-control" type="text" value="<?= $analyse['confidence']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="explanationInput" class="form-label">توضیحات</label>
            <textarea id="explanationInput" name="explanation" class="form-control" rows="4" readonly><?= $analyse['explanation']; ?></textarea>
        </div>
    </div>
<?php elseif ($type === 'blog' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="col-md-12">
        <h1>اطلاعات وبلاگ</h1>
        <a href="?mod=admin&page=blogs" class="btn btn-primary float-end my-2">بازگشت</a>
        <div class="mb-3">
            <label for="blogTitle" class="form-label">عنوان</label>
            <input id="blogTitle" name="title" class="form-control" type="text" value="<?= $blog['title']; ?>" aria-label="readonly input example" readonly>
        </div>
        <div class="mb-3">
            <label for="blogDate" class="form-label">تاریخ</label>
            <input id="blogDate" name="date" class="form-control" type="date" value="<?= $blog['date']; ?>" aria-label="readonly input example" readonly>
        </div>
        <div class="mb-3">
            <label for="blogArticleTextSummarized" class="form-label">خلاصه مقاله</label>
            <textarea id="blogArticleTextSummarized" name="articleTextSummarized" class="form-control" rows="4" aria-label="readonly input example" readonly><?= $blog['article']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="blogSymbols" class="form-label">نمادها</label>
            <input id="blogSymbols" name="symbols" class="form-control" type="text" value="<?= $blog['symbols']; ?>" aria-label="readonly input example" readonly>
        </div>
        <div class="mb-3">
            <label for="blogSentiments" class="form-label">احساسات</label>
            <input id="blogSentiments" name="sentiments" class="form-control" type="text" value="<?= $blog['sentiment']; ?>" aria-label="readonly input example" readonly>
        </div>
        <div class="mb-3">
            <label for="blogExplanations" class="form-label">توضیحات</label>
            <textarea id="blogExplanations" name="explanations" class="form-control" rows="4" aria-label="readonly input example" readonly><?= $blog['explanation']; ?></textarea>
        </div>
    </div>
<?php
endif;
include_once "footer.php";
?>