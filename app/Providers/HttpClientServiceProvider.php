<?php

namespace App\Providers;

use Core\Domain\HttpClients\BaseHttpClientInterface;
use Core\Infrastructure\HttpClients\AbstractBaseHttpClient;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class HttpClientServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientInterface::class, function () {
            return new Client();
        });
        $this->app->bind(BaseHttpClientInterface::class, AbstractBaseHttpClient::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
