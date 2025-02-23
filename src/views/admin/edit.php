<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
<?php if ($type === 'user' && ($permission === 'A' || $permission === 'B')): ?>
    <div class="col-md-12">
            <h1>تغییر اطلاعات کاربر</h1>
            <a href="?mod=admin&page=users" class="btn btn-primary float-end my-2">بازگشت</a>

            <form action="" method="POST">
                <input type="hidden" name="userid" value="<?= $user['id']; ?>">

                <div class="mb-3">
                    <label for="firstName" class="form-label">نام</label>
                    <input id="firstName" name="name" class="form-control" type="text" value="<?= $user['name']; ?>">
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">نام خانوادگی</label>
                    <input id="lastName" name="lastname" class="form-control" type="text" value="<?= $user['last_name']; ?>">
                </div>
                <div class="mb-3">
                    <label for="emailInput" class="form-label">آدرس ایمیل</label>
                    <div style="display: flex; align-items: center;">
                        <input id="emailInput" name="email" class="form-control" type="email" value="<?= $user['email']; ?>">
                </div>
                <div class="mb-3">
                    <label for="passwordInput" class="form-label">رمز عبور جدید</label>
                    <input id="passwordInput" name="password" class="form-control" type="password" value="<?= $user['password']; ?>">
                </div>
                <div class="mb-3">
                    <label for="tokenInput" class="form-label">توکن نوبیتکس</label>
                    <input class="form-control" type="text" id="tokenInput" name="nobitex-token" value="<?= $user['nobitex_token']; ?>">
                </div>
                <div class="mb-3">
                     <label for="creditInput" class="form-label">اعتبار</label>
                     <input class="form-control" type="number" id="creditInput" name="credit" value="<?= $user['credit']; ?>">
                </div>
                <div class="mb-3">
                    <button type="submit" name="edit-user" class="btn btn-primary">
                        اعمال تغییرات
                    </button>
                </div>
            </form>
    </div>
<?php elseif ($type === 'admin' && $permission === 'A'): ?>
    <div class="col-md-12">
        <h1>تغییر اطلاعات ادمین</h1>
        <a href="?mod=admin&page=admins" class="btn btn-primary float-end my-2">بازگشت</a>

        <form action="" method="POST">
            <input type="hidden" name="adminid" value="<?= $admin['id']; ?>">

            <div class="mb-3">
                <label for="firstName" class="form-label">نام</label>
                <input id="firstName" name="name" class="form-control" type="text" value="<?= $admin['name']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="lastName" class="form-label">نام خانوادگی</label>
                <input id="lastName" name="lastname" class="form-control" type="text" value="<?= $admin['lastname']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="emailInput" class="form-label">آدرس ایمیل</label>
                <input id="emailInput" name="email" class="form-control" type="email" value="<?= $admin['email']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="usernameInput" class="form-label">نام کاربری</label>
                <input id="usernameInput" name="username" class="form-control" type="text" value="<?= $admin['username']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="passwordInput" class="form-label">رمز عبور جدید</label>
                <input id="passwordInput" name="password" class="form-control" type="password">
            </div>

            <!-- Role Selection Dropdown -->
            <div class="mb-3">
                <label for="permission" class="form-label">سطح دسترسی</label>
                <select class="form-select" name="permission" id="permission" required>
                    <option value="A" <?= $admin['permission'] == 'A' ? 'selected' : ''; ?>>A</option>
                    <option value="B" <?= $admin['permission'] == 'B' ? 'selected' : ''; ?>>B</option>
                    <option value="C" <?= $admin['permission'] == 'C' ? 'selected' : ''; ?>>C</option>
                </select>
            </div>

            <div class="mb-3">
                <button type="submit" name="edit-admin" class="btn btn-primary">اعمال تغییرات</button>
            </div>
        </form>
    </div>
<?php elseif ($type === 'news' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="col-md-12">
        <h1>تغییر اطلاعات خبر</h1>
        <a href="?mod=admin&page=news" class="btn btn-primary float-end my-2">بازگشت</a>

        <form action="" method="POST">
            <input type="hidden" name="newsid" value="<?= $news['id']; ?>">

            <div class="mb-3">
                <label for="titleInput" class="form-label">عنوان خبر</label>
                <input id="titleInput" name="title" class="form-control" type="text" value="<?= $news['title']; ?>">
            </div>

            <div class="mb-3">
                <label for="dateInput" class="form-label">تاریخ</label>
                <input id="dateInput" name="date" class="form-control" type="date" value="<?= $news['date']; ?>">
            </div>

            <div class="mb-3">
                <label for="linkInput" class="form-label">لینک</label>
                <input id="linkInput" name="link" class="form-control" type="url" value="<?= $news['link']; ?>">
            </div>

            <div class="mb-3">
                <label for="articleTextInput" class="form-label">متن مقاله</label>
                <textarea id="articleTextInput" name="articleText" class="form-control" rows="4"><?= $news['article_text']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="translatedTitleInput" class="form-label">عنوان ترجمه‌شده</label>
                <input id="translatedTitleInput" name="translatedTitle" class="form-control" type="text" value="<?= $news['translated_title']; ?>">
            </div>

            <div class="mb-3">
                <label for="translatedArticleTextInput" class="form-label">متن ترجمه‌شده</label>
                <textarea id="translatedArticleTextInput" name="translatedArticleText" class="form-control" rows="4"><?= $news['translated_text']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="translatedArticleTextSummarizedInput" class="form-label">خلاصه متن ترجمه‌شده</label>
                <textarea id="translatedArticleTextSummarizedInput" name="translatedArticleTextSummarized" class="form-control" rows="2"><?= $news['translated_text_summarzied']; ?></textarea>
            </div>

            <div class="mb-3">
                <button type="submit" name="edit-news" class="btn btn-primary">اعمال تغییرات</button>
            </div>
        </form>
    </div>
<?php elseif ($type === 'analyze' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="col-md-12">
        <h1>تغییر اطلاعات تحلیل</h1>
        <a href="?mod=admin&page=analyses" class="btn btn-primary float-end my-2">بازگشت</a>

        <form action="" method="POST">
            <input type="hidden" name="analyseid" value="<?= $analyse['id']; ?>">

            <div class="mb-3">
                <label for="titleInput" class="form-label">عنوان</label>
                <input id="titleInput" name="title" class="form-control" type="text" value="<?= $analyse['title']; ?>">
            </div>

            <div class="mb-3">
                <label for="dateInput" class="form-label">تاریخ</label>
                <input id="dateInput" name="date" class="form-control" type="date" value="<?= $analyse['date']; ?>">
            </div>

            <div class="mb-3">
                <label for="symbolInput" class="form-label">نماد</label>
                <input id="symbolInput" name="symbol" class="form-control" type="text" value="<?= $analyse['symbol']; ?>">
            </div>

            <div class="mb-3">
                <label for="sentimentInput" class="form-label">احساسات</label>
                <input id="sentimentInput" name="sentiment" class="form-control" type="text" value="<?= $analyse['sentiment']; ?>">
            </div>

            <div class="mb-3">
                <label for="confidenceInput" class="form-label">اعتماد</label>
                <input id="confidenceInput" name="confidence" class="form-control" type="number" step="0.01" value="<?= $analyse['confidence']; ?>">
            </div>

            <div class="mb-3">
                <label for="sentimentIntensityInput" class="form-label">شدت احساسات</label>
                <input id="sentimentIntensityInput" name="sentimentIntensity" class="form-control" type="number" step="0.01" value="<?= $analyse['sentiment_intensity']; ?>">
            </div>

            <div class="mb-3">
                <label for="importanceInput" class="form-label">اهمیت</label>
                <input id="importanceInput" name="importance" class="form-control" type="number" step="0.01" value="<?= $analyse['importance']; ?>">
            </div>

            <div class="mb-3">
                <label for="explanationInput" class="form-label">توضیحات</label>
                <textarea id="explanationInput" name="explanation" class="form-control" rows="4"><?= $analyse['explanation']; ?></textarea>
            </div>

            <div class="mb-3">
                <button type="submit" name="edit-analyze" class="btn btn-primary">اعمال تغییرات</button>
            </div>
        </form>
    </div>
<?php elseif ($type === 'blog' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="col-md-12">
        <h1>تغییر اطلاعات وبلاگ</h1>
        <a href="?mod=admin&page=blogs" class="btn btn-primary float-end my-2">بازگشت</a>

        <form action="" method="POST">
            <input type="hidden" name="blogid" value="<?= $blog['id']; ?>">

            <div class="mb-3">
                <label for="titleInput" class="form-label">عنوان</label>
                <input id="titleInput" name="title" class="form-control" type="text" value="<?= $blog['title']; ?>">
            </div>

            <div class="mb-3">
                <label for="dateInput" class="form-label">تاریخ</label>
                <input id="dateInput" name="date" class="form-control" type="date" value="<?= $blog['date']; ?>">
            </div>

            <div class="mb-3">
                <label for="articleTextSummarizedInput" class="form-label">خلاصه مقاله</label>
                <textarea id="articleTextSummarizedInput" name="articleTextSummarized" class="form-control" rows="4"><?= $blog['article']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="symbolsInput" class="form-label">نمادها</label>
                <input id="symbolsInput" name="symbols" class="form-control" type="text" value="<?= $blog['symbols']; ?>">
            </div>

            <div class="mb-3">
                <label for="sentimentsInput" class="form-label">احساسات</label>
                <input id="sentimentsInput" name="sentiments" class="form-control" type="text" value="<?= $blog['sentiment']; ?>">
            </div>

            <div class="mb-3">
                <label for="explanationsInput" class="form-label">توضیحات</label>
                <textarea id="explanationsInput" name="explanations" class="form-control" rows="4"><?= $blog['explanation']; ?></textarea>
            </div>

            <div class="mb-3">
                <button type="submit" name="edit-blog" class="btn btn-primary">اعمال تغییرات</button>
            </div>
        </form>
    </div>
<?php elseif ($type === 'deal' && ($permission === 'A' || $permission === 'B')): ?>
    <div class="col-md-12">
        <h1>تغییر اطلاعات معامله</h1>
        <a href="?mod=admin&page=deals" class="btn btn-primary float-end my-2">بازگشت</a>

        <form action="" method="POST">
            <input type="hidden" name="dealid" value="<?= $deal['id']; ?>">

            <div class="mb-3">
                <label for="newsSignalInput" class="form-label">سیگنال خبری</label>
                <input id="newsSignalInput" name="newsSignal" class="form-control" type="text" value="<?= $deal['news_signal']; ?>">
            </div>

            <div class="mb-3">
                <label for="tradingSignalInput" class="form-label">سیگنال معاملاتی</label>
                <input id="tradingSignalInput" name="tradingSignal" class="form-control" type="text" value="<?= $deal['trading_signal']; ?>">
            </div>

            <div class="mb-3">
                <label for="tetherAmountInput" class="form-label">مقدار تتر</label>
                <input id="tetherAmountInput" name="tetherAmount" class="form-control" type="number" step="0.01" value="<?= $deal['tether_amount']; ?>">
            </div>

            <div class="mb-3">
                <label for="statusInput" class="form-label">وضعیت</label>
                <input id="statusInput" name="status" class="form-control" type="text" value="<?= $deal['status']; ?>">
            </div>

            <div class="mb-3">
                <button type="submit" name="edit-deals" class="btn btn-primary">اعمال تغییرات</button>
            </div>
        </form>
    </div>
<?php
endif;
?>