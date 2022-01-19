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

    public function getVehicleByType($type)
    {
        return $this->vehicleRepository->getAllVehicleByType($type);
    }
    //
    public function store(VehicleStoreRequest $request)
    {
        return $this->vehicleRepository->store($request->all());
    }

}
