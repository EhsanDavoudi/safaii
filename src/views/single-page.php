<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-4 ps-4 pe-4">
            <div class="mb-3">
                <div class="d-flex gap-2 mb-3">
                    <img src="<?= htmlspecialchars($currencyInfo['icon']) ?>" alt="<?= htmlspecialchars($currencyInfo['name']) ?>" height="56" width="56">
                    <h1 class="fs-2 fw-bold"><?= htmlspecialchars($currencyInfo['name']) ?> (<?= strtoupper(htmlspecialchars($currency)) ?>)</h1>
                </div>
                <div class="d-flex fw-bold">
                    <p>
            <span class="<?= ($statsRLS['dayChange'] ?? 0) >= 0 ? 'highlight-positive' : 'highlight-negative' ?> fs-5">
                <?= number_format(floatval($statsRLS['dayChange'] ?? 0), 2) ?>%
            </span>
                    </p>
                    <p class="ms-auto fs-3">
                        <?= number_format(floatval($statsRLS['latest'] / 10 ?? 0)) ?>تومان
                    </p>
                </div>
            </div>
            <?php if ($currency != 'usdt'): ?>
                <div class="d-flex tt-price bg-body-tertiary p-2 pt-2 pb-0 rounded mb-2">
                    <p class="fw-bold mt-2">قیمت <?= htmlspecialchars($currencyInfo['name']) ?> به تتر</p>
                    <p class="ms-auto mt-2">USDT <span class="fw-bold"><?= ($statsUSDT['latest'] ?? 0) > 0 && ($statsUSDT['latest'] ?? 0) < 1 ? floatval($statsUSDT['latest']) : number_format(floatval($statsUSDT['latest'] ?? 0)) ?></span></p>
                </div>
            <?php endif; ?>
            <div class="d-flex mb-2">
                <p>بالاترین قیمت (24 ساعت)</p>
                <p class="ms-auto">IRT <span class="fw-bold"><?= number_format(floatval($statsRLS['dayHigh'] / 10 ?? 0)) ?></span></p>
            </div>
            <div class="d-flex mb-2">
                <p>پایین‌ترین قیمت (24 ساعت)</p>
                <p class="ms-auto">IRT <span class="fw-bold"><?= number_format(floatval($statsRLS['dayLow'] / 10 ?? 0)) ?></span></p>
            </div>

            <div class="card p-3 pt-4" style="border-radius: 20px">
                <h2 class="mb-3">رمز ارزهای پرطرفدار</h2>
                <table class="table table-borderless">
                    <tbody>
                    <?php
                    // Define the popular currencies
                    $popularCurrencies = ['btc', 'usdt', 'eth', 'shib', 'doge', 'trx'];
                    $filteredCurrencies = in_array($currency, $popularCurrencies) ? array_diff($popularCurrencies, [$currency]) : $popularCurrencies;

                    // Fetch the stats for the filtered currencies
                    $data = fetchStats($filteredCurrencies, 'rls');

                    // Check if data is available and not empty
                    if (!empty($data['stats'])) {
                        foreach ($data['stats'] as $key => $stat) {
                            $sourceCurrency = explode("-", $key)[0];
                            ?>
                            <tr>
                                <td>
                                    <img src="<?= htmlspecialchars(getCryptoIcon($sourceCurrency)) ?>" alt="<?= htmlspecialchars(getCryptoName($sourceCurrency)) ?>" height="26" width="26">
                                    <span class="fw-bold"><?= htmlspecialchars(getCryptoName($sourceCurrency)) ?></span>
                                </td>
                                <td class="fw-bold text-end"><?= number_format($stat['latest'] / 10) ?> تومان</td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-8 pe-4 ps-4">
            <h2 class="fs-2 fw-bold mb-4">نمودار قیمت <?= htmlspecialchars($currencyInfo['name']) ?></h2>
            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
                <div class="tradingview-widget-container__widget"></div>
                <div class="tradingview-widget-copyright"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                    {
                        "width": "100%",
                        "height": "350",
                        "symbol": "BINANCE:<?= strtoupper(htmlspecialchars($currency)) ?>USDT",
                        "interval": "D",
                        "timezone": "Etc/UTC",
                        "theme": "light",
                        "style": "3",
                        "locale": "en",
                        "hide_top_toolbar": true,
                        "withdateranges": true,
                        "allow_symbol_change": false,
                        "calendar": false,
                        "support_host": "https://www.tradingview.com"
                    }
                </script>
            </div>
            <!-- TradingView Widget END -->

            <h2 class="fs-2 mb-4">بازارهای معاملاتی <?= htmlspecialchars($currencyInfo['name']) ?></h2>
            <table class="table table-borderless text-start table-striped">
                <thead>
                <tr>
                    <th scope="col">نام بازار</th>
                    <th scope="col">آخرین قیمت</th>
                    <th scope="col">ارزش معاملات 24 ساعت</th>
                    <th scope="col">حجم معاملات 24 ساعت</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-start"><?= htmlspecialchars($currencyInfo['name']) ?> / تومان</td>
                    <td><?= number_format($statsRLS['latest']/10 ?? 0) ?></td>
                    <td><?= number_format($statsRLS['volumeDst'] ?? 0) ?></td>
                    <td><?= number_format($statsRLS['volumeSrc'] ?? 0) ?></td>
                </tr>
                <?php if ($currency != 'usdt'): ?>
                    <tr>
                        <td class="text-start"><?= htmlspecialchars($currencyInfo['name']) ?> / تتر</td>
                        <td><?= ($statsUSDT['latest'] ?? 0) > 0 && ($statsUSDT['latest'] ?? 0) < 1 ? $statsUSDT['latest'] : number_format($statsUSDT['latest'] ?? 0) ?></td>
                        <td><?= number_format($statsUSDT['volumeDst'] ?? 0) ?></td>
                        <td><?= number_format($statsUSDT['volumeSrc'] ?? 0) ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
