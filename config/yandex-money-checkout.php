<?php

return [
    //API
    'store_id' => env('YANDEX_MONEY_STORE_ID',''),
    'secret' => env('YANDEX_MONEY_SECRET', ''),

    //Payment options
    'payment_method_type' => 'bank_card',
    'currency' => 'RUB',
    'save_payment_method' => true,
    'capture' => false,

    //Redirect
    //Should include order_id in url template
    //Example: /test/{order_id}
     'success_route' => env('YANDEX_MONEY_SUCCESS_ROUTE', 'yandexmoneycheckout.payments.success'),
     'failed_route' => env('YANDEX_MONEY_FAIL_ROUTE', 'yandexmoneycheckout.payments.failed')
];
