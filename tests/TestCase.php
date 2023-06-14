<?php

namespace Skylark\CurrencyConverter\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Skylark\CurrencyConverter\CurrencyServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }
    
    protected function getPackageProviders($app)
    {
        return [
            CurrencyServiceProvider::class,
        ];
    }
}