<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\VehicleRepository;
use App\Interfaces\VehicleRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
    }
}
