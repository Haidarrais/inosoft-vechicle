<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Interfaces\VehicleRepositoryInterface;
use App\Http\Requests\VehicleStoreRequest;

class VehicleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private VehicleRepositoryInterface $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository) 
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function index()
    {
        return $this->vehicleRepository->getAllVehicles();
    }

    public function getVehicleCars()
    {
        return $this->vehicleRepository->getAllVehicleCars();
    }

    public function getVehicleMotorcycles()
    {
        return $this->vehicleRepository->getAllVehicleMotorcycles();

    }
    //dont forget to add request validation inside VehicleStoreRequest if adding new vehicle type
    public function store(VehicleStoreRequest $request)
    {
        return $this->vehicleRepository->store($request->all());
    }

    public function getOrderDetailsByVehicleId($vehicleId)
    {
        return $this->vehicleRepository->getOrderDetailsByVehicleId($vehicleId);
    }

    public function getAllOrderDetails()
    {
        return $this->vehicleRepository->getAllOrderDetails();
    }

}
