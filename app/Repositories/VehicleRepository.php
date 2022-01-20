<?php

namespace App\Repositories;

use App\Interfaces\VehicleRepositoryInterface;
use App\Models\Vehicle;
use App\Models\Motorcycle;
use App\Models\Car;
use App\Interfaces\StockRepositoryInterface;
use App\Models\OrderDetail;

class VehicleRepository implements VehicleRepositoryInterface 
{
    protected StockRepositoryInterface $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }
    public function getAllVehicles() 
    {
        $vehicle = Vehicle::with('vehicle')->get()->toArray();

        return $vehicle;
    }

    public function getAllVehicleMotorcycles()
    {
            $vehicle = Vehicle::where('vehicle_type', 'App\\Models\\Motorcycle')->with('vehicle')->get()->toArray();
            return $vehicle;
    }

    public function getAllVehicleCars()
    {
            $vehicle = Vehicle::where('vehicle_type', 'App\\Models\\Car')->with('vehicle')->get()->toArray();
            return $vehicle;
    }

    public function getVehicleById($VehicleId) 
    {
        return Vehicle::findOrFail($VehicleId);
    }

    public function deleteVehicle($VehicleId) 
    {
        Vehicle::destroy($VehicleId);
    }

    public function store(array $request) 
    {
        try {
            $vehicle = new Vehicle;
            $vehicle->year  = $request['year'];
            $vehicle->color  = $request['color'];
            $vehicle->price  = $request['price'];
            
            // add to this switch if you want to add more vehicle type
            switch ($request['vehicle_type']) {
                case 1:
                    $vehicle->vehicle_type  = 'App\Models\Motorcycle';
                    $detail = new Motorcycle;
                    $detail->suspension_type  = $request['suspension_type'];
                    $detail->transmision_type  = $request['transmision_type'];
                    # code...
                    break;
                case 2:
                    $vehicle->vehicle_type  = 'App\Models\Car';
                    $detail = new Car;
                    $detail->car_type  = $request['car_type'];
                    $detail->capacity  = $request['capacity'];
                    $detail->machine  = $request['machine'];
                    # code...
                    break;
                default:
                    # code...
                    break;
            }
            $detail->save();
            $vehicle->vehicle_id  = $detail->id;
            $vehicle->save();

            $stock = $this->stockRepository->freshStock($vehicle->id);

            //return successful response
            return response()->json([
                'vehicle' => $vehicle,
                'stock' => $stock,
                // "$vehicle->vehicle_type_name" => $detail, 
                'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
    

    public function updateVehicle($VehicleId, array $newDetails) 
    {
        return Vehicle::whereId($VehicleId)->update($newDetails);
    }
    
    public function getAllOrderDetails()
    {
        $data = OrderDetail::with('stock.vehicle', 'order')
        ->whereHas('stock.vehicle')->get();
        $subtotalPrice = 0;
        $subtotalQty = 0;
        foreach ($data as $value) {
            $subtotalPrice += $value->stock->vehicle->price;
            $subtotalQty += $value->qty;
        }
        return response()->json([
            'success' => true,
            'message' => 'Data penjualan kendaraan',
            'data'    => [
                'total_omset_penjualan' => $subtotalPrice,
                'total_jumlah_penjualan' => $subtotalQty,
                'detail_penjualan' => $data,
                ]
        ],200);
    }

    public function getOrderDetailsByVehicleId($vehicleId)
    {
        $data = OrderDetail::with('stock.vehicle', 'order')
        ->whereHas('stock.vehicle', function($q) use ($vehicleId){
            $q->where('id', $vehicleId);
        })->get();
        $subtotalPrice = 0;
        $subtotalQty = 0;
        foreach ($data as $value) {
            $subtotalPrice += $value->stock->vehicle->price;
            $subtotalQty += $value->qty;
        }
        return response()->json([
            'success' => true,
            'message' => 'Data penjualan kendaraan',
            'data'    => [
                'total_omset_penjualan' => $subtotalPrice,
                'total_jumlah_penjualan' => $subtotalQty,
                'detail_penjualan' => $data,
                ]
        ],200);
    }

}
