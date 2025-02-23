<?php

namespace models;

class NobitexApi
{
    private const API_URL = 'https://api.nobitex.ir/';
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Makes a request to the Nobitex API.
     *
     * @param string $endpoint The API endpoint to call.
     * @param array $data The data to send in the request body.
     * @param string $method The HTTP method to use (POST by default).
     * @return string The API response.
     */
    private function callApi(string $endpoint, array $data = [], string $method = 'POST'): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => self::API_URL . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Authorization: Token ' . $this->token,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /**
     * Gets market statistics.
     *
     * @param array $data The data to send in the request body.
     * @return string The API response.
     */
    public function getMarketStats(array $data): string
    {
        return $this->callApi('market/stats', $data);
    }

    /**
     * Adds an order.
     *
     * @param string $type The order type.
     * @param string $srcCurrency The source currency.
     * @param string $dstCurrency The destination currency.
     * @param float $amount The order amount.
     * @param float $price The order price.
     * @param float $stopPrice The stop price.
     * @param float $stopLimitPrice The stop limit price.
     * @return string The API response.
     */
    public function addOrder(
        string $type,
        string $srcCurrency,
        string $dstCurrency,
        float $amount,
        float $price,
        float $stopPrice,
        float $stopLimitPrice
    ): string
    {
        $data = [
            'type' => $type,
            'srcCurrency' => $srcCurrency,
            'dstCurrency' => $dstCurrency,
            'amount' => $amount,
            'mode' => 'oco',
            'price' => $price,
            'stopPrice' => $stopPrice,
            'stopLimitPrice' => $stopLimitPrice,
            //'clientOrderId' => $clientOrderId
        ];
        return $this->callApi('market/orders/add', $data);
    }

    /**
     * Gets a list of wallets.
     *
     * @return string The API response.
     */
    public function walletsList(): string
    {
        return $this->callApi('users/wallets/list', [], 'GET');
    }

    /**
     * Gets the user profile.
     *
     * @return string The API response.
     */
    public function profile(): string
    {
        return $this->callApi('users/profile', [], 'GET');
    }
}