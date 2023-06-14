<?php

namespace Skylark\CurrencyConverter\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class CurrencyController extends Controller
{
    /**
    * @response scenario=success {
    *  "success": true,
    *  "message": "10 USD = 10.793 EURO",
    *  "data": 10.793
    * }
    * @response scenario=Failed {
    *  "success": false,
    *  "message": "Failed to get data"
    *  "errors"  => "....."
    * }
    * @queryParam currency string required. Example: USD.
    * @queryParam amount integer|decimal required. Here, amount is the target amount that to be exchange in Euro. Example: 100 (100 USD = 107.93 Euro).
    */
    public function calculateCurrency ($amount, $currency) {        
        if (!is_numeric($amount)) {
            return response([
                'success' => false,
                'message' => 'The first parameter must be an integer or decimal.'
            ]);
        }

        $curr = strtoupper(strval($currency));
        $url = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";

        $dataArray = $this->fetchDataFromEuropeanBank($url);

        $existCurrency = Arr::first($dataArray, function ($value, $key) use ($curr) {
            return $value['currency'] == $curr;
        });

        if (!$existCurrency) {
            return response([
                'success' => false,
                'message' => 'Your expected currency not found. Please try for another currency.'
            ]);
        }

        $result = $this->calculation($existCurrency['rate'], $amount);

        return response([
            'success' => true,
            'message' => $amount. ' ' . $curr . ' = ' . $result . ' EURO',
            'data' => $result
        ]);
    }


    /**
     * @queryParam rate integer|decimal required. Here, rate is currency rate. Example: 1.08 (1 Euro = 1.08 USD).
     * @queryParam amount integer|decimal required. Here, amount is the target amount that to be exchange in Euro. Example: 100 (100 USD = 107.93 Euro).
    */
    public function calculation ($rate, $amount) {
        return $rate * $amount;
    }


    /**
     * @queryParam url string required. url is for fetching the exchange rate of the day from the Duropean Central Bank daily reference. is currency rate. Example: $url = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml".
    */
    public function fetchDataFromEuropeanBank ($url) {
        $xmlString = file_get_contents($url);

        $xml = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        
        $datas = isset($array['Cube']['Cube']['Cube']) ? $array['Cube']['Cube']['Cube'] : [];

        $newArray = [];
        foreach ($datas as $key => $element) {
            $val = $element['@attributes'];
            array_push($newArray, $val);
        }

        return $newArray;
    }
}
