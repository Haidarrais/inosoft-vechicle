<?php

namespace App\Interfaces;

interface StockRepositoryInterface 
{
    public function getAllStocks();
    public function getAllStockCars();
    public function getAllStockMotorcycles();
    public function getStockByVehicleId($vehicleId);
    public function getStockById($stockId);
    public function freshStock($vehicleId);
}
