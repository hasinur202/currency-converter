<?php

Route::group(['namespace' => 'Skylark\CurrencyConverter\Http\Controllers'], function() {
    Route::get('currency', 'CurrencyController@calculateCurrency');
});

