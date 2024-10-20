<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

use App\Repositories\MovieRepository;
use App\Interfaces\MovieRepositoryInterface;

use App\Repositories\MediaRepository;
use App\Interfaces\MediaRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MovieRepositoryInterface::class , MovieRepository::class);
        $this->app->bind(MediaRepositoryInterface::class , MediaRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
