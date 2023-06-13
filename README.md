# SkyLark Currency Converter

## This will return the exchange rate of Euro for the amount and currency that you are given.


## Installation

Install the package by the following command,

    composer require skylark/currency-converter


Add the provider inside the config/app.php,

    Skylark\CurrencyConverter\CurrencyServiceProvider::class,


Give the following two parameter to get the Euro currency:
    (i) amount
    (ii) currency

Api is:
    BaseUrl/currency-converter/{amount}/{currency}
    
    Example:
    http://127.0.0.1:8000/currency-converter/100/usd