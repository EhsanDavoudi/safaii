<?php
function loadView($page, $var = [])
{
    extract($var);
    include VIEW_DIR . $page . '.php';
}

function convertToEnglishNumbers($string) {
    $persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٫'];
    $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.'];
    return str_replace($persianDigits, $englishDigits, $string);
}

function redirect($url)
{
    header("Location: $url");
    exit();
}

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

function strHash($password)
{
    return md5( 'helloUser' . $password . 'helloUser');
}

function fetchStats($symbols, $dstCurrency)
{
    $curl = curl_init();

    // If $symbols is an array, implode it into a comma-separated string
    if (is_array($symbols)) {
        $symbols = implode(',', $symbols);
    }

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.nobitex.ir/market/stats',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode([
            'srcCurrency' => $symbols,
            'dstCurrency' => $dstCurrency
        ]),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}

function fetchCharts($currency)
{
    $currency = strtolower($currency);
    $cacheKey = 'chart_' . $currency;

    // Try to fetch from cache
    $cachedImage = apcu_fetch($cacheKey);

    if ($cachedImage !== false) {
        return $cachedImage;
    }

    // Fetch the chart image from the URL
    $symbolUrl = "https://nobitex.ir/nobitex-cdn/charts/$currency.svg";
    $imageData = @file_get_contents($symbolUrl);

    if ($imageData !== false) {
        // Store in cache and return the image data
        apcu_store($cacheKey, $imageData, 300);
        return $imageData;
    } else {
        // Return a placeholder or null if the image is not available
        return null;
    }
}

function renderCryptoTable($currencies = [])
{
    // Fetch the data using the provided currencies
    $data = fetchStats($currencies, 'rls');

    $output = '';

    // Check if data is available
    if (!empty($data['stats'])) {
        foreach ($data['stats'] as $key => $stat) {
            $sourceCurrency = explode("-", $key)[0];
            $chartImageData = fetchCharts($sourceCurrency);
            $chartImageTag = $chartImageData
                ? '<img src="data:image/svg+xml;base64,' . base64_encode($chartImageData) . '" alt="Chart for ' . strtoupper($sourceCurrency) . '" class="img-fluid" style="width: 200px; filter: invert(37%) sepia(96%) saturate(403%) hue-rotate(2deg) brightness(102%) contrast(101%);">'
                : '<span>نمودار موجود نیست</span>';
            $output .= '
            <tr>
                <td>
                    <a href="?mod=currency&page=' . urlencode($sourceCurrency) . '" class="text-decoration-none link-dark">
                        <img src="' . getCryptoIcon($sourceCurrency) . '" alt="' . getCryptoName($sourceCurrency) . '" class="me-2" style="width: 30px; height: 30px;">
                        <span class="fw-bold">' . getCryptoName($sourceCurrency) . '</span>
                        <span class="text-muted">' . strtoupper($sourceCurrency) . '</span>
                    </a>
                </td>
                <td class="fw-bold">' . number_format($stat['latest'] / 10)  . ' تومان</td>
                <td class="text-nowrap" style="color: ' . ($stat['dayChange'] >= 0 ? '#28a745' : '#dc3545') . '">
                    <i class="fas fa-caret-' . ($stat['dayChange'] >= 0 ? 'up' : 'down') . '"></i>
                    ' . abs($stat['dayChange']) . '%
                </td>
                <td><span class="fw-bold">' . strtoupper($sourceCurrency) . '</span>' . $stat['volumeSrc'] . '</td>
                <td>' . $chartImageTag . '</td>
            </tr>';
        }
    } else {
        $output .= '
        <tr>
            <td colspan="5" class="text-center">خطا در دریافت داده‌ها</td>
        </tr>';
    }
    return $output;
}

function getCryptoIcon($currency)
{
    $cryptoIcons = [
        "btc" => "https://cryptologos.cc/logos/bitcoin-btc-logo.png",
        "usdt" => "https://cryptologos.cc/logos/tether-usdt-logo.png",
        "eth" => "https://cryptologos.cc/logos/ethereum-eth-logo.png",
        "shib" => "https://cryptologos.cc/logos/shiba-inu-shib-logo.png",
        "doge" => "https://cryptologos.cc/logos/dogecoin-doge-logo.png",
        "trx" => "https://cryptologos.cc/logos/tron-trx-logo.png",
        "ltc" => "https://cryptologos.cc/logos/litecoin-ltc-logo.png",
        "xrp" => "https://cryptologos.cc/logos/xrp-xrp-logo.png",
        "bch" => "https://cryptologos.cc/logos/bitcoin-cash-bch-logo.png",
        "bnb" => "https://cryptologos.cc/logos/binance-coin-bnb-logo.png",
        "eos" => "https://cryptologos.cc/logos/eos-eos-logo.png",
        "ada" => "https://cryptologos.cc/logos/cardano-ada-logo.png",
        "link" => "https://cryptologos.cc/logos/chainlink-link-logo.png",
        "xlm" => "https://cryptologos.cc/logos/stellar-xlm-logo.png",
        "uni" => "https://cryptologos.cc/logos/uniswap-uni-logo.png",
        "sol" => "https://cryptologos.cc/logos/solana-sol-logo.png",
        "avax" => "https://cryptologos.cc/logos/avalanche-avax-logo.png",
        "xmr" => "https://cryptologos.cc/logos/monero-xmr-logo.png",
        "ton" => "https://cryptologos.cc/logos/toncoin-ton-logo.png"
    ];

    return $cryptoIcons[$currency] ?? null; // Returns the icon URL for the specified currency, or null if not found
}

function getCryptoName($currency)
{
    $cryptoNames = [
        "btc" => "بیت کوین",
        "usdt" => "تتر",
        "eth" => "اتریوم",
        "shib" => "هزار شیبا",
        "doge" => "دوج کوین",
        "trx" => "ترون",
        "ltc" => "لایت کوین",
        "xrp" => "ریپل",
        "bch" => "بیت کوین کش",
        "bnb" => "بایننس کوین",
        "eos" => "ایاس",
        "ada" => "کاردانو",
        "link" => "چین لینک",
        "xlm" => "استلار",
        "uni" => "یونی سواپ",
        "sol" => "سولانا",
        "avax" => "آوالانچ",
        "xmr" => "مونرو",
        "ton" => "تون"
    ];

    return $cryptoNames[$currency] ?? null; // Returns the name for the specified currency, or null if not found
}

function getAnalysisFromSentiment($sentiment)
{
    $analysisMap = [
        'positive' => 'مثبت',
        'neutral' => 'خنثی',
        'negative' => 'منفی',
    ];

    return $analysisMap[$sentiment] ?? 'نامشخص';  // Default analysis if sentiment is not found
}
