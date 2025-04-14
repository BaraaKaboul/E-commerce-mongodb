<?php

namespace App\Providers;

use App\Repositories\AdminRepository;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\ShopRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class, UserRepository::class
        );
        $this->app->bind(
            AdminRepositoryInterface::class, AdminRepository::class
        );
        $this->app->bind(
            ShopRepositoryInterface::class, ShopRepository::class
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
