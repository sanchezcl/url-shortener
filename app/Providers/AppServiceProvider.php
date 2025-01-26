<?php

namespace App\Providers;

use App\Repositories\UrlRepository;
use App\Repositories\UrlRepositoryInterface;
use App\Services\UrlService;
use App\Services\UrlServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UrlRepositoryInterface::class,
            UrlRepository::class
        );

        $this->app->bind(
            UrlServiceInterface::class,
            UrlService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
