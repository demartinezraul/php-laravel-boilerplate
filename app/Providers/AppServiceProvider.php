<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Core\Domain\Contracts\DomainNotificationInterface;
use Core\Domain\Entities\DomainNotification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DomainNotificationInterface::class, DomainNotification::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
