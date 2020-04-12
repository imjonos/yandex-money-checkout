<?php

namespace CodersStudio\YandexMoneyCheckout\Models;

use Illuminate\Database\Eloquent\Model;

class YandexMoneyPayment extends Model
{
    public  $fillable = [
        'amount',
        'yandex_money_status_id',
        'order_id',
        'payment_id',
        'description'
    ];

    /**
     * Get status
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('CodersStudio\YandexMoneyCheckout\Models\YandexMoneyStatus', 'yandex_money_status_id', 'id');
    }
}
