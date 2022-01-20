<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    // Route "/api/register
    $router->post('register', 'AuthController@register');

    // Route "/api/login
    $router->post('login', 'AuthController@login');
    $router->group(['middleware' => 'jwt.auth'], function () use ($router) {
        $router->group(['prefix' => 'kendaraan'], function () use ($router) {
            $router->get('/', 'VehicleController@index');
            $router->post('/', 'VehicleController@store');
            $router->get('/mobil', 'VehicleController@getVehicleCars');
            $router->get('/motor', 'VehicleController@getVehicleMotorcycles');
            $router->get('/penjualan', 'VehicleController@getAllOrderDetails');
            $router->get('/penjualan/{vehicleId}', 'VehicleController@getOrderDetailsByVehicleId');
        });

        $router->group(['prefix' => 'stock'], function () use ($router) {
            $router->get('/', 'StockController@index');
            $router->get('/mobil', 'StockController@getStockCars');
            $router->get('/motor', 'StockController@getStockMotorcycles');
            $router->get('/{stockId}', 'StockController@getStockById');
            $router->get('/kendaraan/{vehicleId}', 'StockController@getStockByVehicleId');
        });

        $router->group(['prefix' => 'order'], function () use ($router) {
            $router->get('/', 'OrderController@index');
            $router->post('/', 'OrderController@placeOrder');
        });
    });
});