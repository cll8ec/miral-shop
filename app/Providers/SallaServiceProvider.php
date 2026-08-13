<?php

namespace App\Providers;

use App\Domains\Salla\Client\FakeSallaClient;
use App\Domains\Salla\Client\SallaClientInterface;
use Illuminate\Support\ServiceProvider;

class SallaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            SallaClientInterface::class,
            FakeSallaClient::class
        );
    }

    public function boot(): void
    {
        //
    }
}
