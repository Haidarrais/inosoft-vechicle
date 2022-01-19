<?php

namespace App\Interfaces;

interface VehicleRepositoryInterface 
{
    public function getAllVehicles();
    public function getAllVehicleByType($type);
    public function getVehicleById($VehicleId);
    public function deleteVehicle($VehicleId);
    public function store(array $request);
    // public function createCar(array $request);
    // public function createMotorcycle(array $request);
    // public function updateCar($VehicleId, array $newDetails);
    // public function updateMotorcycle($VehicleId, array $newDetails);
}
