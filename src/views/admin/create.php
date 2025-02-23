<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
<?php if ($type === 'admin'  && $permission === 'A'): ?>
    <div class="col-md-12">
        <h1>ساخت ادمین</h1>
        <a href="?mod=admin&page=users" class="btn btn-primary float-end my-2">بازگشت</a>

        <form action="" method="POST">
            <div class="mb-2">
                <label for="firstName" class="form-label">نام</label>
                <input class="form-control" type="text" id="firstName" name="name" required>
            </div>

            <div class="mb-2">
                <label for="lastName" class="form-label">نام خانوادگی</label>
                <input class="form-control" type="text" id="lastName" name="lastname" required>
            </div>

            <div class="mb-2">
                <label for="userName" class="form-label">نام کاربری</label>
                <input class="form-control" type="text" id="userName" name="username" required>
            </div>

            <div class="mb-2">
                <label for="emailInput" class="form-label">آدرس ایمیل</label>
                <input class="form-control" type="email" id="emailInput" name="email">
            </div>

            <div class="mb-2">
                <label for="passwordInput" class="form-label">رمز عبور</label>
                <input class="form-control" type="password" id="passwordInput" name="password" required>
            </div>

            <div class="mb-2">
                <label for="permission" class="form-label">سطح دسترسی</label>
                <select class="form-select form-select-sm" name="permission" aria-label="Small select" required>
                    <option selected disabled>سطح دسترسی</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                </select>
            </div>

            <div class="mb-2">
                <button type="submit" name="create-admin" class="btn btn-primary">ساخت کاربر</button>
            </div>
        </form>
    </div>
<?php elseif ($type === 'user' && ($permission === 'A' || $permission === 'B')):?>
    <div class="col-md-12">
        <h1>ساخت کاربر</h1>
        <a href="?mod=admin&page=users" class="btn btn-primary float-end my-2">بازگشت</a>
        <form action="" method="POST">
            <div class="mb-2">
                <label for="firstName" class="form-label">نام</label>
                <input class="form-control" type="text" id="firstName" name="name" required>
            </div>

            <div class="mb-2">
                <label for="lastName" class="form-label">نام خانوادگی</label>
                <input class="form-control" type="text" id="lastName" name="lastname" required>
            </div>

            <div class="mb-2">
                <label for="emailInput" class="form-label">آدرس ایمیل</label>
                <input class="form-control" type="email" id="emailInput" name="email" required>
            </div>

            <div class="mb-2">
                <label for="passwordInput" class="form-label">رمز عبور</label>
                <input class="form-control" type="password" id="passwordInput" name="password" required>
            </div>

            <div class="mb-2">
                <label for="tokenInput" class="form-label">توکن</label>
                <input class="form-control" type="text" id="tokenInput" name="nobitexToken">
            </div>

            <div class="mb-2">
                <label for="creditInput" class="form-label">اعتبار</label>
                <input class="form-control" type="number" id="creditInput" name="credit"">
            </div>

            <div class="mb-2">
                <button type="submit" name="create-user" class="btn btn-primary">ساخت کاربر</button>
            </div>
        </form>
    </div>
<?php elseif ($type === 'news' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="col-md-12">
        <h1>ایجاد خبر</h1>
        <a href="?mod=admin&page=news" class="btn btn-primary float-end my-2">بازگشت</a>

        <form action="" method="POST">
            <div class="mb-2">
                <label for="titleInput" class="form-label">عنوان خبر</label>
                <input class="form-control" type="text" id="titleInput" name="title" required>
            </div>

            <div class="mb-2">
                <label for="dateInput" class="form-label">تاریخ</label>
                <input class="form-control" type="date" id="dateInput" name="date" required>
            </div>

            <div class="mb-2">
                <label for="linkInput" class="form-label">لینک</label>
                <input class="form-control" type="url" id="linkInput" name="link">
            </div>

            <div class="mb-2">
                <label for="articleTextInput" class="form-label">متن مقاله</label>
                <textarea class="form-control" id="articleTextInput" name="article_text" rows="4" required></textarea>
            </div>

            <div class="mb-2">
                <label for="translatedTitleInput" class="form-label">عنوان ترجمه‌شده</label>
                <input class="form-control" type="text" id="translatedTitleInput" name="translated_title">
            </div>

            <div class="mb-2">
                <label for="translatedArticleTextInput" class="form-label">متن ترجمه‌شده</label>
                <textarea class="form-control" id="translatedArticleTextInput" name="translated_text" rows="4"></textarea>
            </div>

            <div class="mb-2">
                <label for="translatedArticleTextSummarizedInput" class="form-label">خلاصه متن ترجمه‌شده</label>
                <textarea class="form-control" id="translatedArticleTextSummarizedInput" name="translated_text_summarized" rows="2"></textarea>
            </div>

            <div class="mb-2">
                <button type="submit" name="create-news" class="btn btn-primary">ایجاد خبر</button>
            </div>
        </form>
    </div>
<?php elseif ($type === 'analyze' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="col-md-12">
        <h1>ایجاد تحلیل</h1>
        <a href="?mod=admin&page=analyses" class="btn btn-primary float-end my-2">بازگشت</a>

        <form action="" method="POST">
            <div class="mb-2">
                <label for="titleInput" class="form-label">عنوان</label>
                <input class="form-control" type="text" id="titleInput" name="title" required>
            </div>

            <div class="mb-2">
                <label for="dateInput" class="form-label">تاریخ</label>
                <input class="form-control" type="date" id="dateInput" name="date" required>
            </div>

            <div class="mb-2">
                <label for="symbolInput" class="form-label">نماد</label>
                <input class="form-control" type="text" id="symbolInput" name="symbol" required>
            </div>

            <div class="mb-2">
                <label for="sentimentInput" class="form-label">احساسات</label>
                <input class="form-control" type="text" id="sentimentInput" name="sentiment" required>
            </div>

            <div class="mb-2">
                <label for="confidenceInput" class="form-label">اعتماد</label>
                <input class="form-control" type="number" step="0.01" id="confidenceInput" name="confidence" required>
            </div>

            <div class="mb-2">
                <label for="sentimentIntensityInput" class="form-label">شدت احساسات</label>
                <input class="form-control" type="number" step="0.01" id="sentimentIntensityInput" name="sentimentIntensity" required>
            </div>

            <div class="mb-2">
                <label for="importanceInput" class="form-label">اهمیت</label>
                <input class="form-control" type="number" step="0.01" id="importanceInput" name="importance" required>
            </div>

            <div class="mb-2">
                <label for="explanationInput" class="form-label">توضیحات</label>
                <textarea class="form-control" id="explanationInput" name="explanation" rows="4" required></textarea>
            </div>

            <div class="mb-2">
                <button type="submit" name="create_analyse" class="btn btn-primary">ایجاد تحلیل</button>
            </div>
        </form>
    </div>
<?php elseif ($type === 'blog' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="col-md-12">
        <h1>ایجاد مطلب جدید برای وبلاگ</h1>
        <a href="?mod=admin&page=blog" class="btn btn-primary float-end my-2">بازگشت</a>

        <form action="" method="POST">
            <div class="mb-2">
                <label for="titleInput" class="form-label">عنوان</label>
                <input class="form-control" type="text" id="titleInput" name="title" required>
            </div>

            <div class="mb-2">
                <label for="dateInput" class="form-label">تاریخ</label>
                <input class="form-control" type="date" id="dateInput" name="date" required>
            </div>

            <div class="mb-2">
                <label for="articleTextSummarizedInput" class="form-label">خلاصه مقاله</label>
                <textarea class="form-control" id="articleTextSummarizedInput" name="articleTextSummarized" rows="3" required></textarea>
            </div>

            <div class="mb-2">
                <label for="symbolsInput" class="form-label">نمادها</label>
                <input class="form-control" type="text" id="symbolsInput" name="symbols">
            </div>

            <div class="mb-2">
                <label for="sentimentsInput" class="form-label">احساسات</label>
                <input class="form-control" type="text" id="sentimentsInput" name="sentiments">
            </div>

            <div class="mb-2">
                <label for="explanationsInput" class="form-label">توضیحات</label>
                <textarea class="form-control" id="explanationsInput" name="explanations" rows="4"></textarea>
            </div>

            <div class="mb-2">
                <button type="submit" name="create_blog" class="btn btn-primary">ایجاد مطلب وبلاگ</button>
            </div>
        </form>
    </div>
<?php
endif;
?>