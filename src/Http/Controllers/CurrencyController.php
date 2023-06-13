<?php

namespace Skylark\CurrencyConverter\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function calculateCurrency () {
        return 'Hello from controller';
    }
}
