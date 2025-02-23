<?php

namespace controllers;
use models\NewsModel;
use system\BaseController;

class HomeController extends BaseController
{
    private $validator;

    public function __construct() {
        $this->validator = $this->isAuthenticated();
    }

    public function index() {
        loadView('header', [
            'title' => "خانه",
            'validator' => $this->validator
        ]);
        loadView('home');
        loadView('footer', ['title' => "خانه"]);
    }

    public function currencies($currency) {
        // Fetch currency information and statistics
        $currencyInfo = [
            'name' => getCryptoName($currency),
            'icon' => getCryptoIcon($currency),
        ];

        // Fetch RLS stats
        $statsRLS = fetchStats([$currency], 'rls');
        $statsRLS = $statsRLS['stats'][$currency . '-rls'] ?? null;

        // Initialize the USDT stats as null
        $statsUSDT = null;

        // Fetch USDT stats only if the currency is not USDT
        if ($currency !== 'usdt') {
            $statsUSDTData = fetchStats([$currency], 'usdt');
            $statsUSDT = $statsUSDTData['stats'][$currency . '-usdt'] ?? null;
        }

        // Load views with the necessary data
        loadView('header', [
            'title' => " قیمت " . $currencyInfo['name'],
            'validator' => $this->validator
        ]);
        loadView('single-page', [
            'currency' => $currency,
            'currencyInfo' => $currencyInfo,
            'statsRLS' => $statsRLS,
            'statsUSDT' => $statsUSDT
        ]);
        loadView('footer', ['title' => " قیمت " . $currencyInfo['name']]);
    }


    public function table()
    {
        $cryptoTable = renderCryptoTable(["btc", "usdt", "eth", "shib", "doge", "trx", "ltc", "xrp", "bch", "bnb", "eos", "ada", "link", "xlm", "uni", "sol", "avax", "xmr", "ton"]);

        loadView('header', [
            'title' => "قیمت ارز های دیجیتال",
            'validator' => $this->validator
        ]);
        loadView('table', [
            'cryptoTable' => $cryptoTable,
        ]);
        loadView('footer', ['title' => "قیمت ارز های دیجیتال"]);
    }

    public function blog()
    {
        global $conn;
        $newsModel = new NewsModel($conn);

        $newsData = $newsModel->getBlogData(10);
        loadView('header', [
            'title' => "تحلیل اخبار",
            'validator' => $this->validator
        ]);
        loadView('news-blog', [
            'newsData' => $newsData
        ]);
        loadView('footer', ['title' => "تحلیل اخبار"]);
    }
}