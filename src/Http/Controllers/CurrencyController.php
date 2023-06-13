<?php

namespace Skylark\CurrencyConverter\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use SimpleXMLElement;

class CurrencyController extends Controller
{
    public function calculateCurrency ($amount, $currency) {        
        if (!is_numeric($amount)) {
            return 'The first parameter must be an integer or decimal.';
        }

        $curr = strtoupper(strval($currency));
        $url = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";

        $dataArray = $this->fetchDataFromEuropeanBank($url);

        $existCurrency = Arr::first($dataArray, function ($value, $key) use ($curr) {
            return $value['currency'] == $curr;
        });

        if (!$existCurrency) {
            return 'Your expected currency not found. Please try for another currency.';
        }

        $result = $this->calculation($existCurrency['rate'], $amount);
        // $result = $amount. ' ' . $curr . ' = ' . $eruo . ' EURO';
        return $result;
    }


    public function calculation ($rate, $amount) {
        return $rate * $amount;
    }


    public function fetchDataFromEuropeanBank ($url) {
        $xmlString = file_get_contents($url);

        $xml = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        
        $datas = $array['Cube']['Cube']['Cube'];

        $newArray = [];
        foreach ($datas as $key => $element) {
            $val = $element['@attributes'];
            array_push($newArray, $val);
        }

        return $newArray;
    }
}
