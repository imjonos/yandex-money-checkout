<?php
Route::pattern('order', '[0-9]+');
Route::post('/payments/webhook', 'CodersStudio\YandexMoneyCheckout\Http\Controllers\PaymentController@webhook')->name('yandexmoneycheckout.payments.webhook');
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/payments', 'CodersStudio\YandexMoneyCheckout\Http\Controllers\PaymentController@store')->name('yandexmoneycheckout.payments.store');
    Route::get('/payments/redirect/{order}', 'CodersStudio\YandexMoneyCheckout\Http\Controllers\PaymentController@redirect')->name('yandexmoneycheckout.payments.redirect');
    Route::get('/payments/success/{order}', 'CodersStudio\YandexMoneyCheckout\Http\Controllers\PaymentController@success')->name('yandexmoneycheckout.payments.success');
    Route::get('/payments/failed/{order}', 'CodersStudio\YandexMoneyCheckout\Http\Controllers\PaymentController@failed')->name('yandexmoneycheckout.payments.failed');
});
