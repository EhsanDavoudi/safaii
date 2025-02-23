<?php

use models\NobitexApi;

/**
 *دریافت آخرین موجودی نوبیتکس
 * @param $token
 * @return mixed|void
 */
function getWalletBalance($token)
{
    $state = new NobitexApi($token);
    $jsonWallet = $state->walletsList();
    // تبدیل JSON به آرایه
    $walletsArray = json_decode($jsonWallet, true);
    // بررسی موفقیت تبدیل JSON به آرایه
    if ($walletsArray['status'] == 'ok') {
        $wallets = $walletsArray['wallets'];

        // جستجو برای کیف پول با ارز مشخص
        foreach ($wallets as $wallet) {
            if ($wallet['currency'] == "usdt") {
                return $wallet['balance'];
            }
        }
    }

    //اگر کیف پول وجود نداشت null برگردان
    return null;
}


/**
 * ثبت سفارش اسپات(oco) بعد از دریافت ورودی‌های زیر از بخش تکنیکال
 * @param $token
 * @param $type
 * @param $srcCurrency
 * @param $amount
 * @param $price
 * @param $stopPrice
 * @param $stopLimitPrice
 * @return bool|string
 */
function placeOrder($token, $type, $srcCurrency, $amount, $price, $stopPrice, $stopLimitPrice)
{
    $state = new NobitexApi($token);
    $dstCurrency = 'rls'; // This should likely be configurable in the future

    // Validate input parameters here (e.g., $type, $srcCurrency, $amount, etc.)

    $addOrderResponse = $state->addOrder($type, $srcCurrency, $dstCurrency, $amount, $price, $stopPrice, $stopLimitPrice);

    if ($addOrderResponse) {
        return $addOrderResponse;
    } else {
        // Handle the error more gracefully, perhaps by throwing an exception
        // or returning a more informative error message.
        return 'error';
    }
}

// Example usage:
$token = 'your_nobitex_api_token';
$type = 'sell';
$srcCurrency = 'usdt';
$amount = 10; // Example amount
$price = '607000';
$stopPrice = '595000';
$stopLimitPrice = '594000';

//$orderResult = placeOrder($token, $type, $srcCurrency, $amount, $price, $stopPrice, $stopLimitPrice);

//if ($orderResult !== 'error') {
//    echo "Order placed successfully. Response: " . $orderResult;
//} else {
//    echo "Error placing order.";
//}