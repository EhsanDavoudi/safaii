<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
<?php if ($type === 'user' && ($permission === 'A' || $permission === 'B')): ?>
    <div class="container-fluid mt-4" style="font-size: 0.7rem !important;">
        <div class="row">
    <div class="col-md-12">
        <h1>لیست کاربران</h1>
        <a href="?mod=admin&page=createuser" class="btn btn-primary float-end my-2">اضافه کردن کاربر</a>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>آدرس ایمیل</th>
                    <th>رمز عبور</th>
                    <th>توکن</th>
                    <th>اعتبار</th>
                    <th>اقدامات</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id']; ?></td>
                        <td><?= $user['name']; ?></td>
                        <td><?= $user['last_name']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= $user['password']; ?></td>
                        <td><?= $user['nobitex_token']; ?></td>
                        <td><?= $user['credit']; ?></td>
                        <td>
                            <a href="?mod=admin&page=viewuser&id=<?= $user['id']; ?>" class="btn btn-info btn-sm">نمایش</a>
                            <a href="?mod=admin&page=edituser&id=<?= $user['id']; ?>" class="btn btn-success btn-sm">ویرایش</a>
                            <a href="?mod=admin&page=deleteuser&id=<?= $user['id']; ?>" class="btn btn-danger btn-sm">حذف</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php if ($total_pages > 1): ?>
        <nav class="d-flex align-items-center justify-content-center" aria-label="Page navigation">
            <ul class="pagination">
                <!-- Previous Button -->
                <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?mod=admin&page=users&page_num=<?= max(1, $current_page - 1) ?>" tabindex="-1">قبلی</a>
                </li>

                <!-- Page Numbers -->
                <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                    <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                        <a class="page-link" href="?mod=admin&page=users&page_num=<?= $page ?>"><?= $page ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?mod=admin&page=users&page_num=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
    </div>
    </div>
<?php elseif ($type === 'admin'  && $permission === 'A'): ?>
    <div class="container-fluid mt-4" style="font-size: 0.7rem !important;">
        <div class="row">
            <div class="col-md-12">
                <h1>لیست ادمین ها</h1>
                <a href="?mod=admin&page=createadmin" class="btn btn-primary float-end my-2">اضافه کردن ادمین</a>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>نام</th>
                        <th>نام خانوادگی</th>
                        <th>آدرس ایمیل</th>
                        <th>نام کاربری</th>
                        <th>رمز عبور</th>
                        <th>سطح دسترسی</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?= $admin['id']; ?></td>
                            <td><?= $admin['name']; ?></td>
                            <td><?= $admin['lastname']; ?></td>
                            <td><?= $admin['email']; ?></td>
                            <td><?= $admin['username']; ?></td>
                            <td><?= $admin['password']; ?></td>
                            <td><?= $admin['permission']; ?></td>
                            <td>
                                <a href="?mod=admin&page=viewadmin&id=<?= $admin['id']; ?>" class="btn btn-info btn-sm">نمایش</a>
                                <a href="?mod=admin&page=editadmin&id=<?= $admin['id']; ?>" class="btn btn-success btn-sm">ویرایش</a>
                                <a href="?mod=admin&page=deleteadmin&id=<?= $admin['id']; ?>" class="btn btn-danger btn-sm">حذف</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if ($total_pages > 1): ?>
            <nav class="d-flex align-items-center justify-content-center" aria-label="Page navigation">
                <ul class="pagination">
                    <!-- Previous Button -->
                    <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?mod=admin&page=admins&page_num=<?= max(1, $current_page - 1) ?>" tabindex="-1">قبلی</a>
                    </li>

                    <!-- Page Numbers -->
                    <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                        <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="?mod=admin&page=admins&page_num=<?= $page ?>"><?= $page ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next Button -->
                    <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?mod=admin&page=admins&page_num=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
<?php elseif ($type === 'news' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="container-fluid mt-4" style="font-size: 0.7rem !important;">
        <div class="row">
            <div class="col-md-12">
                <h1>لیست اخبار</h1>
                <a href="?mod=admin&page=createnews" class="btn btn-primary float-end my-2">اضافه کردن خبر</a>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>عنوان</th>
                        <th>تاریخ</th>
                        <th>لینک</th>
                        <th>متن مقاله</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($newss as $news): ?>
                        <tr>
                            <td><?= $news['id']; ?></td>
                            <td><?= $news['title']; ?></td>
                            <td><?= $news['date']; ?></td>
                            <td><?= $news['link']; ?></td>
                            <td><?= mb_strimwidth($news['article_text'], 0, 50, '...'); ?></td>
                            <td>
                                <a href="?mod=admin&page=viewnews&id=<?= $news['id']; ?>" class="btn btn-info btn-sm">نمایش</a>
                                <a href="?mod=admin&page=editnews&id=<?= $news['id']; ?>" class="btn btn-success btn-sm">ویرایش</a>
                                <a href="?mod=admin&page=deletenews&id=<?= $news['id']; ?>" class="btn btn-danger btn-sm">حذف</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php if ($total_pages > 1): ?>
            <nav class="d-flex align-items-center justify-content-center" aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?mod=admin&page=news&page_num=<?= max(1, $current_page - 1) ?>" tabindex="-1">قبلی</a>
                    </li>
                    <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                        <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="?mod=admin&page=news&page_num=<?= $page ?>"><?= $page ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?mod=admin&page=news&page_num=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
        </div>
    </div>
<?php elseif ($type === 'analyze' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="container-fluid mt-4" style="font-size: 0.7rem !important;">
        <div class="row">
            <div class="col-md-12">
                <h1>لیست تحلیل‌ها</h1>
<!--                <a href="?mod=admin&page=createanalyze" class="btn btn-primary float-end my-2">اضافه کردن تحلیل</a>-->
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>نماد</th>
                        <th>احساسات</th>
                        <th>اعتماد</th>
                        <th>شدت احساسات</th>
                        <th>اهمیت</th>
                        <th>توضیحات</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($analyzes as $analyze): ?>
                        <tr>
                            <td><?= $analyze['id']; ?></td>
                            <td><?= $analyze['symbol']; ?></td>
                            <td><?= $analyze['sentiment']; ?></td>
                            <td><?= $analyze['confidence']; ?></td>
                            <td><?= $analyze['sentiment_intensity']; ?></td>
                            <td><?= $analyze['importance']; ?></td>
                            <td><?= $analyze['explanation']; ?></td>
                            <td>
                                <a href="?mod=admin&page=viewanalyze&id=<?= $analyze['id']; ?>" class="btn btn-info btn-sm">نمایش</a>
                                <a href="?mod=admin&page=editanalyze&id=<?= $analyze['id']; ?>" class="btn btn-success btn-sm">ویرایش</a>
                                <a href="?mod=admin&page=deleteanalyze&id=<?= $analyze['id']; ?>" class="btn btn-danger btn-sm">حذف</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if ($total_pages > 1): ?>
                <nav class="d-flex align-items-center justify-content-center" aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?mod=admin&page=analyzes&page_num=<?= max(1, $current_page - 1) ?>" tabindex="-1">قبلی</a>
                        </li>
                        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                            <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                                <a class="page-link" href="?mod=admin&page=analyzes&page_num=<?= $page ?>"><?= $page ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?mod=admin&page=analyzes&page_num=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
<?php elseif ($type === 'deal' && ($permission === 'A' || $permission === 'B')): ?>
    <div class="container-fluid mt-4" style="font-size: 0.7rem !important;">
        <div class="row">
            <div class="col-md-12">
                <h1>لیست معاملات</h1>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>USER ID</th>
                        <th>سیگنال خبری</th>
                        <th>سیگنال معاملاتی</th>
                        <th>مقدار تتر</th>
                        <th>وضعیت</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($deals as $deal): ?>
                        <tr>
                            <td><?= $deal['id']; ?></td>
                            <td><?= $deal['user_id']; ?></td>
                            <td><?= $deal['news_signal']; ?></td>
                            <td><?= $deal['trading_signal']; ?></td>
                            <td><?= $deal['tether_amount']; ?></td>
                            <td><?= $deal['status']; ?></td>
                            <td>
                                <a href="?mod=admin&page=viewdeal&id=<?= $deal['id']; ?>" class="btn btn-info btn-sm">نمایش</a>
                                <a href="?mod=admin&page=editdeal&id=<?= $deal['id']; ?>" class="btn btn-success btn-sm">ویرایش</a>
                                <a href="?mod=admin&page=deletedeal&id=<?= $deal['id']; ?>" class="btn btn-danger btn-sm">حذف</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php if ($total_pages > 1): ?>
                <nav class="d-flex align-items-center justify-content-center" aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?mod=admin&page=deals&page_num=<?= max(1, $current_page - 1) ?>" tabindex="-1">قبلی</a>
                        </li>
                        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                            <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                                <a class="page-link" href="?mod=admin&page=deals&page_num=<?= $page ?>"><?= $page ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?mod=admin&page=deals&page_num=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
            </div>
        </div>
    </div>
<?php elseif ($type === 'nobTokenList' && ($permission === 'A' || $permission === 'B')):

    ?>

        <div class="container-fluid mt-4" style="font-size: 0.7rem !important;">
            <div class="row">
                <div class="col-md-12">
                    <h1>لیست کاربران با توکن Nobitex</h1>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>نام</th>
                            <th>نام خانوادگی</th>
                            <th>آدرس ایمیل</th>
                            <th>توکن Nobitex</th>
                            <th>اعتبار</th>
                            <th>اقدامات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($nobTokenLists as $user): ?>
                            <tr>
                                <td><?= $user['id']; ?></td>
                                <td><?= $user['name']; ?></td>
                                <td><?= $user['last_name']; ?></td>
                                <td><?= $user['email']; ?></td>
                                <td><?= $user['nobitex_token']; ?></td>
                                <td><?= $user['credit']; ?></td>
                                <td>
                                    <a href="?mod=admin&page=createdeal&id=<?= $user['id']; ?>" class="btn btn-warning btn-sm">ساخت معامله برای کاربر</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($total_pages > 1): ?>
                    <nav class="d-flex align-items-center justify-content-center" aria-label="Page navigation">
                        <ul class="pagination">
                            <!-- Previous Button -->
                            <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?mod=admin&page=dealabeusers&page_num=<?= max(1, $current_page - 1) ?>" tabindex="-1">قبلی</a>
                            </li>

                            <!-- Page Numbers -->
                            <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                                <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="?mod=admin&page=dealabeusers&page_num=<?= $page ?>"><?= $page ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Button -->
                            <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?mod=admin&page=dealabeusers&page_num=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
<?php elseif ($type === 'blog' && ($permission === 'A' || $permission === 'B' || $permission === 'C')): ?>
    <div class="container-fluid mt-4" style="font-size: 0.7rem !important;">
        <div class="row">
            <div class="col-md-12">
                <h1>لیست بلاگ‌ها</h1>
                <a href="?mod=admin&page=createblog" class="btn btn-primary float-end my-2">اضافه کردن بلاگ</a>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>عنوان</th>
                        <th>تاریخ</th>
                        <th>خلاصه مقاله</th>
                        <th>نمادها</th>
                        <th>احساسات</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($blogs as $blog): ?>
                        <tr>
                            <td><?= $blog['id']; ?></td>
                            <td><?= $blog['title']; ?></td>
                            <td><?= $blog['date']; ?></td>
                            <td><?= substr($blog['article'], 0, 50) . '...'; ?></td>
                            <td><?= $blog['symbols']; ?></td>
                            <td><?= $blog['sentiment']; ?></td>
                            <td>
                                <a href="?mod=admin&page=viewblog&id=<?= $blog['id']; ?>" class="btn btn-info btn-sm">نمایش</a>
                                <a href="?mod=admin&page=editblog&id=<?= $blog['id']; ?>" class="btn btn-success btn-sm">ویرایش</a>
                                <a href="?mod=admin&page=deleteblog&id=<?= $blog['id']; ?>" class="btn btn-danger btn-sm">حذف</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if ($total_pages > 1): ?>
                    <nav class="d-flex align-items-center justify-content-center" aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?mod=admin&page=blogs&page_num=<?= max(1, $current_page - 1) ?>" tabindex="-1">قبلی</a>
                            </li>
                            <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                                <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="?mod=admin&page=blogs&page_num=<?= $page ?>"><?= $page ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?mod=admin&page=blogs&page_num=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php
endif;
?>