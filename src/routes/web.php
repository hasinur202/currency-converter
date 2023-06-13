<?php

Route::group(['namespace' => 'Skylark\CurrencyConverter\Http\Controllers'], function() {
    Route::get('currency-converter/{amount}/{currency}', 'CurrencyController@calculateCurrency');
});

