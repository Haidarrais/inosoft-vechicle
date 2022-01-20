<?php

namespace App\Interfaces;

interface VehicleRepositoryInterface 
{
    public function getAllVehicles();
    public function getAllVehicleCars();
    public function getAllVehicleMotorcycles();
    public function getVehicleById($VehicleId);
    public function deleteVehicle($VehicleId);
    public function store(array $request);
    public function getOrderDetailsByVehicleId($vehicleId);
    public function getAllOrderDetails();
}
