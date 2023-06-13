<?php

namespace Skylark\CurrencyConverter\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SimpleXMLElement;

class CurrencyController extends Controller
{
    public function calculateCurrency ($amount, $currency) {
        $url = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
        $xmlString = file_get_contents($url);

        $xml = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        return $array;


    }
}
