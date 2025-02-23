<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="logo-icon">
            <a class="navbar-brand" href="<?= BASE_URL ?>">
                <img src="<?=ASSET_REF?>images/trl'd-logo.png" class="img-fluid" alt="Logo" width="60"> <!-- Corrected logo name -->
            </a>
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="fs-4 fw-bold mb-0">SAFAII</h5>
        </div>
        <div class="sidebar-close">
            <span class="material-icons-outlined">close</span>
        </div>
    </div>
    <div class="sidebar-nav">
        <!--navigation-->
        <ul class="metismenu" id="sidenav">
            <li>
                <a class="" href="?mod=admin&page=dashboard">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i></div>
                    <div class="menu-title">داشبورد</div>
                </a>
            </li>
            <li>
                <a class="" href="?mod=admin&page=profile">
                    <div class="parent-icon"><i class="material-icons-outlined">person</i></div>
                    <div class="menu-title">پروفایل</div>
                </a>
            </li>

            <?php if ($permission === 'A'): ?>
                <li>
                    <a class="" href="?mod=admin&page=admins">
                        <div class="parent-icon"><i class="material-icons-outlined">manage_accounts</i></div>
                        <div class="menu-title">ادمین ها</div>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($permission === 'A' || $permission === 'B'): ?>
                <li>
                    <a class="" href="?mod=admin&page=users">
                        <div class="parent-icon"><i class="material-icons-outlined">group</i></div>
                        <div class="menu-title">کاربران</div>
                    </a>
                </li>
                <li>
                    <a class="" href="?mod=admin&page=deals">
                        <div class="parent-icon"><i class="material-icons-outlined">attach_money</i></div>
                        <div class="menu-title">معاملات</div>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($permission === 'A' || $permission === 'B' || $permission === 'C'): ?>
                <li>
                    <a class="" href="?mod=admin&page=news">
                        <div class="parent-icon"><i class="material-icons-outlined">newspaper</i></div>
                        <div class="menu-title">اخبار</div>
                    </a>
                </li>
                <li>
                    <a class="" href="?mod=admin&page=analyze">
                        <div class="parent-icon"><i class="material-icons-outlined">insights</i></div>
                        <div class="menu-title">تحلیل ها</div>
                    </a>
                </li>
                <li>
                    <a class="" href="?mod=admin&page=blog">
                        <div class="parent-icon"><i class="material-icons-outlined">article</i></div>
                        <div class="menu-title">وبلاگ</div>
                    </a>
                </li>
            <?php endif; ?>

            <li>
                <a class="" href="?mod=admin&page=logout">
                    <div class="parent-icon"><i class="material-icons-outlined">logout</i></div>
                    <div class="menu-title">خروج</div>
                </a>
            </li>
        </ul>
        <!--end navigation-->
    </div>
</aside>
