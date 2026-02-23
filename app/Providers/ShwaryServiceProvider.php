<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Shwary\Config;
use Shwary\ShwaryClient;

class ShwaryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ShwaryClient::class, function () {
            return new ShwaryClient(
                Config::fromArray(config('services.shwary'))
            );
        });
    }
}
