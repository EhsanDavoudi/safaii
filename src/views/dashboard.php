<?php include_once "sidebar.php"?>
        <div class="mt-4">
            <h1>خوش اومدی <?= htmlspecialchars($userInformation['name']) ?></h1>
            <form action="" method="POST" class="mt-2">
                <?php if (empty($userInformation['nobitex_token'])): ?>
                    <div class="mb-2">
                        <?= $message ?>
                        <label for="tokenInput" class="form-label">توکن نوبیتکس</label>
                        <input class="form-control" type="text" id="tokenInput" name="nobitex-token">
                    </div>
                    <button type="submit" name="token-submit" id="submit" class="btn btn-primary fs-4 mt-2">ثبت توکن</button>
                <?php else: ?>
                    <div class="mb-2">
                        <?= $message ?>
                        <label for="tokenInput" class="form-label">توکن نوبیتکس</label>
                        <div style="display: flex; align-items: center;">
                            <input id="tokenInput" class="form-control" type="password" value="<?= htmlspecialchars($userInformation['nobitex_token']) ?>" aria-label="readonly input example" name="nobitex-token" readonly>
                            <a href="javascript:void(0);" class="focus-ring py-1 px-2 text-decoration-none border rounded-2" onclick="toggleEditingToken('tokenInput', 'tokenSubmitBtn')">
                                <img id="tokenEditImg" class="edit-img" src="<?= ASSET_REF ?>images/edit.png" alt="edit" width="30" height="30">
                            </a>
                        </div>
                        <button type="submit" name="token-delete" id="submit" class="btn btn-danger fs-4 mt-2">حذف توکن</button>
                        <button type="submit" name="token-submit" id="tokenSubmitBtn" class="btn btn-primary fs-4 mt-2" style="display: none;">تغییر توکن</button>
                    </div>
                    <div class="mb-2">
                        <label for="amountInput" class="form-label">مقدار (تتر)</label>
                        <input class="form-control" type="text" id="amountInput" name="amount" placeholder="مقدار"
                               value="<?= $balance/2 ?>">
                        <div id="error" class="error">مقدار نمی‌تواند بیشتر از <?= $balance ?> تتر باشد!</div>
                    </div>
                    <div class="mb-2">
                        <label for="priceRange" class="form-label"></label>
                        <input type="range" class="form-range" id="priceRange" value="0" min="0" max="100" step="1">
                        <div id="percentageDisplay" class="percentage">0%</div>
                    </div>
                    <div id="signalVolumeFields" class="mb-2">
                        <?php if (!empty($userSettings)): ?>
                            <?php foreach ($userSettings as $index => $data): ?>
                                <div class="mb-2 d-flex align-items-center">
                                    <div class="input-group" style="width: 44%;">
                                        <input type="text" class="form-control" name="custom_signal_percentage[]" value="<?= htmlspecialchars($data['news_signal']) ?>">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <div class="input-group ms-2" style="width: 44%;">
                                        <input type="text" class="form-control" name="custom_trade_volume[]" value="<?= htmlspecialchars($data['trading_signal']) ?>">
                                        <span class="input-group-text">USDT</span>
                                    </div>
                                    <button type="button" class="btn btn-danger ms-2" onclick="removeField(this)">-</button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach ($defaultSettings as $index => $data): ?>
                                <div class="mb-2 d-flex align-items-center">
                                    <div class="input-group" style="width: 44%;">
                                        <input type="text" class="form-control" name="custom_signal_percentage[]" value="<?= htmlspecialchars($data['news_signal']) ?>">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <div class="input-group ms-2" style="width: 44%;">
                                        <input type="text" class="form-control" name="custom_trade_volume[]" value="<?= htmlspecialchars($data['trading_signal']) ?>">
                                        <span class="input-group-text">USDT</span>
                                    </div>
                                    <button type="button" class="btn btn-danger ms-2" onclick="removeField(this)">-</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div class="mb-2 d-flex align-items-center">
                            <div class="input-group" style="width: 44%;">
                                <input type="text" class="form-control" name="custom_signal_percentage[]" placeholder="درصد سیگنال">
                                <span class="input-group-text">%</span>
                            </div>
                            <div class="input-group ms-2" style="width: 44%;">
                                <input type="text" class="form-control" name="custom_trade_volume[]" placeholder="حجم معامله">
                                <span class="input-group-text">USDT</span>
                            </div>
                            <button type="button" class="btn btn-success ms-2"  onclick="addField()" >+</button>
                        </div>
                    </div>

                    <button type="submit" name="settings-submit" id="submit" class="btn btn-primary fs-4">ذخیره تنظیمات</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<script>
    let balance = <?php echo json_encode($balance); ?>;
    function addField() {
        const container = document.getElementById('signalVolumeFields');
        const lastRow = container.lastElementChild;


        const signalPercentage = lastRow.querySelector('input[name="custom_signal_percentage[]"]').value;
        const tradeVolume = lastRow.querySelector('input[name="custom_trade_volume[]"]').value;

        if (signalPercentage.trim() === '' || tradeVolume.trim() === '') {
            alert('لطفا هر دو فیلد را پر کنید.');
            return;
        }

        const newFilledRow = document.createElement('div');
        newFilledRow.className = 'mb-2 d-flex align-items-center';
        newFilledRow.innerHTML = `
        <div class="input-group" style="width: 44%;">
            <input type="text" class="form-control" name="custom_signal_percentage[]" value="${signalPercentage}" readonly>
            <span class="input-group-text">%</span>
        </div>
        <div class="input-group ms-2" style="width: 44%;">
            <input type="text" class="form-control" name="custom_trade_volume[]" value="${tradeVolume}" readonly>
            <span class="input-group-text">USDT</span>
        </div>
        <button type="button" class="btn btn-danger ms-2" onclick="removeField(this)">-</button>
    `;

        container.insertBefore(newFilledRow, lastRow);

        lastRow.querySelector('input[name="custom_signal_percentage[]"]').value = '';
        lastRow.querySelector('input[name="custom_trade_volume[]"]').value = '';
    }

    function removeField(button) {
        const container = document.getElementById('signalVolumeFields');
        container.removeChild(button.parentElement);
    }

    // اضافه کردن ردیف اولیه با دکمه "+" هنگام بارگذاری صفحه
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('signalVolumeFields');
        if (!container.lastElementChild || !container.lastElementChild.querySelector('button.btn-success')) {
            const initialRow = document.createElement('div');
            initialRow.className = 'mb-2 d-flex align-items-center';
            initialRow.innerHTML = `
            <div class="input-group" style="width: 44%;">
                <input type="text" class="form-control" name="custom_signal_percentage[]" placeholder="درصد سیگنال">
                <span class="input-group-text">%</span>
            </div>
            <div class="input-group ms-2" style="width: 44%;">
                <input type="text" class="form-control" name="custom_trade_volume[]" placeholder="حجم معامله">
                <span class="input-group-text">USDT</span>
            </div>
            <button type="button" class="btn btn-success ms-2" onclick="addField()">+</button>`;
            container.appendChild(initialRow);
        }
    });
</script>
<script src="../assets/js/dashboard-scripts.js"></script>