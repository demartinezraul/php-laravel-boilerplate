<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\AbstractBaseRepository;
use Core\Domain\Repositories\BaseRepositoryInterface;
use Core\Domain\Repositories\FaturaRepositoryInterface;
use Core\Infrastructure\Repositories\FaturaRepository;
use Core\Domain\Repositories\HistoricoFaturaRepositoryInterface;
use Core\Infrastructure\Repositories\HistoricoFaturaRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, AbstractBaseRepository::class);
        $this->app->bind(FaturaRepositoryInterface::class, FaturaRepository::class);
        $this->app->bind(HistoricoFaturaRepositoryInterface::class, HistoricoFaturaRepository::class);
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
