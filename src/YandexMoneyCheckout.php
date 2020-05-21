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
     * Get Yandex Money idempotenceKey
     * @return string
     */
    protected function getIdempotenceKey():string
    {
        return  uniqid('', true);
    }

    /**
     * Create payment
     *
     * @param $paymentData
     * @return \YandexCheckout\Request\Payments\CreatePaymentResponse|null
     */
    public function create(array $paymentData)
    {
        $response = null;
        try {
            $response = $this->_client->createPayment($paymentData,  $this->getIdempotenceKey());
            YandexMoneyPayment::create([
                'amount' => $paymentData['amount']['value'],
                'description' => $paymentData['description'],
                'order_id' => $paymentData['metadata']['order_id'],
                'payment_id' => $response->getId(),
                'yandex_money_status_id' => 1
            ]);
        } catch (\Exception $exception) {
            report($exception);
        }
        return $response;
    }

    /**
     * Capture payment
     * @param YandexMoneyPayment $payment
     * @return \YandexCheckout\Request\Payments\Payment\CancelResponse
     */
    public function capture(YandexMoneyPayment $payment)
    {
        $response = null;
        if($payment->status->name === 'waiting_for_capture') {
            try {
                $response = $this->_client->cancelPayment(
                    $payment->payment_id,
                    $this->getIdempotenceKey()
                );
            } catch (\Exception $exception) {
                report($exception);
            }
        }
        return $response;
    }

    /**
     * Cancel payment
     * @param YandexMoneyPayment $payment
     * @return \YandexCheckout\Request\Payments\Payment\CreateCaptureResponse|null
     */
    public function cancel(YandexMoneyPayment $payment)
    {
        $response = null;
        if($payment->status->name === 'waiting_for_capture') {
            try {
                $response = $this->_client->capturePayment(
                    array(
                        'amount' => $payment->amount,
                    ),
                    $payment->payment_id,
                    $this->getIdempotenceKey()
                );
            } catch (\Exception $exception) {
                report($exception);
            }
        }
        return $response;
    }

}
