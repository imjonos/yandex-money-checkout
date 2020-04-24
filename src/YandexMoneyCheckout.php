<?php

namespace CodersStudio\YandexMoneyCheckout;

use CodersStudio\YandexMoneyCheckout\Models\YandexMoneyPayment;
use YandexCheckout\Client;

class YandexMoneyCheckout
{
    /**
     * Yandex Money client
     * @var Client
     */
    private Client $_client;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_client = app('YandexCheckoutClient');
    }

    /**
     * Create payment
     *
     * @param $paymentData
     * @return \YandexCheckout\Request\Payments\CreatePaymentResponse|null
     */
    public function create(array $paymentData)
    {
        $idempotenceKey = uniqid('', true);
        $response = null;
        try {
            $response = $this->_client->createPayment($paymentData, $idempotenceKey);
            YandexMoneyPayment::create([
                'amount' =>  $paymentData['amount']['value'],
                'description' =>  $paymentData['description'],
                'order_id' => $paymentData['metadata']['order_id'],
                'payment_id' => $response->getId(),
                'yandex_money_status_id' => 1
            ]);
        } catch (\Exception $exception) {
            report($exception);
        }
        return $response;
    }

}
