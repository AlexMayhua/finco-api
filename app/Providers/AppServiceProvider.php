<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Contracts\AuthServiceInterface;
use App\Services\AuthService;
use App\Contracts\ProfileRepositoryInterface;
use App\Repositories\ProfileRepository;
use App\Contracts\ProfileServiceInterface;
use App\Services\ProfileService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
