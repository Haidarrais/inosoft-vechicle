<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\VehicleRepository;
use App\Interfaces\VehicleRepositoryInterface;
use App\Repositories\StockRepository;
use App\Interfaces\StockRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Interfaces\OrderRepositoryInterface;
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
        $this->app->bind(StockRepositoryInterface::class, StockRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }
}
