<?php

namespace CodersStudio\YandexMoneyCheckout\Models;

use Illuminate\Database\Eloquent\Model;

class YandexMoneyCard extends Model
{
    public  $fillable = [
        'first6',
        'last4',
        'card_type',
        'yandex_money_payment_id'
    ];

    /**
     * Get status
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->belongsTo('CodersStudio\YandexMoneyCheckout\Models\YandexMoneyPayment', 'yandex_money_payment_id', 'id');
    }
}
