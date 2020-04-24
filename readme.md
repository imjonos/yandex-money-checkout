# Laravel yandex money checkout

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/codersStudio/yandex-money-checkout.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/codersStudio/yandex-money-checkout.svg?style=flat-square)](https://packagist.org/packages/codersStudio/yandex-money-checkout)

## Install
`composer require coderstudio/yandex-money-checkout`

## Usage
This is package provide base Controller and views for implement Yandex Money payments
It's provide webhook url https://some.com/payments/webhook

Config file:

     //API
    'store_id' => env('YANDEX_MONEY_STORE_ID',''),
    'secret' => env('YANDEX_MONEY_SECRET', ''),

    //Payment options
    'payment_method_type' => 'bank_card',
    'currency' => 'RUB',
    'save_payment_method' => true,
    'capture' => false,

    //Redirect
    //Should include orderId in url template
    //Example: /test/{orderId}
     'success_route' => env('YANDEX_MONEY_SUCCESS_ROUTE', 'yandexmoneycheckout.payments.success'),
     'failed_route' => env('YANDEX_MONEY_FAIL_ROUTE', 'yandexmoneycheckout.payments.failed')


## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```

## Credits

- [Eugeny Nosenko](https://github.com/imjonos)

## Security
If you discover any security-related issues, please email info@coders.studio instead of using the issue tracker.

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.
