<?php
namespace  CodersStudio\YandexMoneyCheckout\Events;

use CodersStudio\YandexMoneyCheckout\Models\YandexMoneyPayment;
use Illuminate\Queue\SerializesModels;

class PaymentStatusChanged
{
    use SerializesModels;

    public YandexMoneyPayment $payment;

    /**
     * Create a new event instance.
     *
     * @param YandexMoneyPayment $payment
     */
    public function __construct(YandexMoneyPayment $payment)
    {
        $this->payment = $payment;
    }
}
