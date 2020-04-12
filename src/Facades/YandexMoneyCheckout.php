<?php

namespace CodersStudio\YandexMoneyCheckout\Facades;

use Illuminate\Support\Facades\Facade;

class  YandexMoneyCheckout extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'YandexMoneyCheckout';
    }

}
