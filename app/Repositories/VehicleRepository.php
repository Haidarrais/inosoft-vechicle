<?php

namespace App\Repositories;

use App\Interfaces\VehicleRepositoryInterface;
use App\Models\Vehicle;
use App\Models\Motorcycle;
use App\Models\Car;
use App\Models\VehicleType;
use Illuminate\Support\Facades\Auth;

class VehicleRepository implements VehicleRepositoryInterface 
{
    public function getAllVehicles() 
    {
        $motor = Vehicle::with('motor', 'type')->whereHas('motor')->get();
        $mobil = Vehicle::with('mobil', 'type')->whereHas('mobil')->get();

        return response()->json([
            'mobil' => $mobil,
            'motor' => $motor,
        ], 200);
    }

    public function getAllVehicleByType($type)
    {
        try {
            $query = Vehicle::query();
            $query->whereHas('type', function($q) use($type){
                $q->where('id', $type);
                $q->orWhere('name', $type);
            });

            //variable t is for identifying relation name
            $t = false;
            
            if(!(int)$type){ $query->with("$type"); }else{$t = VehicleType::find($type); $query->with($t?$t->name:'');};
            $vehicle = $query->get();

            return response()->json([
                $t?$t->name:$type => $vehicle,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage());
        }
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
            $vehicle->vehicle_type  = $request['vehicle_type'];
            $vehicle->save();

            switch ($request['vehicle_type']) {
                case 1:
                    $detail = new Motorcycle;
                    $detail->vehicle_id  = $vehicle->id;
                    $detail->suspension_type  = $request['suspension_type'];
                    $detail->transmision_type  = $request['transmision_type'];
                    # code...
                    break;
                case 2:
                    $detail = new Car;
                    $detail->vehicle_id  = $vehicle->id;
                    $detail->type  = $request['type'];
                    $detail->capacity  = $request['capacity'];
                    $detail->machine  = $request['machine'];
                    # code...
                    break;
                default:
                    # code...
                    break;
            }

            $detail->save();

            //return successful response
            return response()->json([
                'vehicle' => $vehicle, 
                "$vehicle->vehicle_type_name" => $detail, 
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
}
