<?php

namespace App\Providers;

use Core\Domain\Services\Contracts\FaturaServiceInterface;
use Core\Domain\Services\FaturaService;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FaturaServiceInterface::class, FaturaService::class);
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
