<?php

Route::group(['namespace' => 'Skylark\CurrencyConverter\Http\Controllers'], function() {
    Route::get('currency/{amount}/{currency}', 'CurrencyController@calculateCurrency');
});

