<?php

namespace Skylark\CurrencyConverter\Tests\Unit;

use Orchestra\Testbench\TestCase;

class CurrencyControllerTest extends TestCase
{
    public function test_currency_test()
    {        
        $response = $this->call('GET', '/currency-converter', ['100', 'usd']);

        $response->assertStatus($response->status(), 200);
    } 
}