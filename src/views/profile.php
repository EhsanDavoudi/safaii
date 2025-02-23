<?php include_once "sidebar.php"?>
        <div class="mt-4">
            <?= $message ?>
            <h2 class="text-primary mb-1">ویرایش پروفایل</h2>
            <form action="" method="POST" class="mt-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="mb-2">
                            <label for="firstName" class="form-label">نام</label>
                            <div style="display: flex; align-items: center;">
                                <input id="firstName" name="firstname" class="form-control" type="text" value="<?= htmlspecialchars($userInformation['name']) ?>" aria-label="readonly input example" readonly>
                                <a href="javascript:void(0);" class="focus-ring py-1 px-2 text-decoration-none border rounded-2" onclick="toggleEditing('firstName', 'firstNameEditImg')">
                                    <img id="firstNameEditImg" class="edit-img" src="<?= ASSET_REF ?>images/edit.png" alt="edit" width="30" height="30">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="mb-2">
                            <label for="lastName" class="form-label">نام خانوادگی</label>
                            <div style="display: flex; align-items: center;">
                                <input id="lastName" name="lastname" class="form-control" type="text" value="<?= htmlspecialchars($userInformation['last_name']) ?>" aria-label="readonly input example" readonly>
                                <a href="javascript:void(0);" class="focus-ring py-1 px-2 text-decoration-none border rounded-2" onclick="toggleEditing('lastName', 'lastNameEditImg')">
                                    <img id="lastNameEditImg" class="edit-img" src="<?= ASSET_REF ?>images/edit.png" alt="edit" width="30" height="30">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="mb-2">
                            <label for="emailInput" class="form-label">آدرس ایمیل</label>
                            <div style="display: flex; align-items: center;">
                                <input id="emailInput" name="email" class="form-control" type="email" value="<?= htmlspecialchars($userInformation['email']) ?>" aria-label="readonly input example" readonly>
                                <a href="javascript:void(0);" class="focus-ring py-1 px-2 text-decoration-none border rounded-2" onclick="toggleEditing('emailInput', 'emailEditImg')">
                                    <img id="emailEditImg" class="edit-img" src="<?= ASSET_REF ?>images/edit.png" alt="edit" width="30" height="30">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="mb-2">
                            <label for="passwordInput" class="form-label">رمز عبور جدید</label>
                            <div style="display: flex; align-items: center;">
                                <input id="passwordInput" name="password" class="form-control" type="password" placeholder="رمز عبور جدید" readonly>
                                <a href="javascript:void(0);" class="focus-ring py-1 px-2 text-decoration-none border rounded-2" onclick="toggleEditing('passwordInput', 'passwordInputEditImg')">
                                    <img id="passwordInputEditImg" class="edit-img" src="<?=ASSET_REF?>images/edit.png" alt="edit" width="30" height="30">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="edit-submit" id="submit" class="btn btn-primary w-100">ذخیره تغییرات</button>
            </form>
        </div>

    </div>
</div>

<script src="../assets/js/dashboard-scripts.js"></script>