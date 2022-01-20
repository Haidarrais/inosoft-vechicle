<?php

namespace App\Repositories;

use App\Interfaces\StockRepositoryInterface;
use App\Models\Stock;
use Exception;
use Illuminate\Http\Response;

class StockRepository implements StockRepositoryInterface 
{
    protected $vehicleType = [
        'App\\Models\\Motorcycle',
        'App\\Models\\Car'
    ];
    public function getAllStocks() 
    {
        try {
            $stock = Stock::with('vehicle')->get();

            if (!count($stock)) {
                return false;
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Stock found',
                'data'    => $stock
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Stock not found',
            ],404);
        }
    }

    public function getAllStockMotorcycles()
    {
        try {
            $stock = Stock::with('vehicle')
            ->whereHas('vehicle', function($q){
                $q->where('vehicle_type', $this->vehicleType[0]);
            })
            ->get();

            if (!count($stock)) {
                throw new Exception();
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Stock found',
                'data'    => $stock
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Stock not found',
            ],404);
        }
    }

    public function getAllStockCars()
    {
        try {
            $stock = Stock::with('vehicle')
            ->whereHas('vehicle', function($q){
                $q->where('vehicle_type', $this->vehicleType[1]);
            })
            ->get();

            if (!count($stock)) {
                throw new Exception();
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Stock found',
                'data'    => $stock
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Stock not found',
            ],404);
        }
    }
    
    public function freshStock($vehicleId) 
    {
        $stock = new Stock;
        $stock->vehicle_id = $vehicleId;
        $stock->qty = 0;
        $stock->save();

        return $stock;
    }

    public function getStockByVehicleId($vehicleId) 
    {
        $stock = Stock::with('vehicle')
        ->where('vehicle_id', $vehicleId)
        ->first();
        return response()->json([
            'success' => true,
            'message' => 'Stock found',
            'data'    => $stock
        ],200);
    }

    public function getStockById(
        
        $stockId) 
    {
        $stock = Stock::with('vehicle')->findOrFail($stockId);
        return response()->json([
            'success' => true,
            'message' => 'Stock found',
            'data'    => $stock
        ],200);
    }

    public function updateStock($StockId, array $newDetails) 
    {
        try {
            $stock = Stock::whereId($StockId)->update($newDetails);

            return response()->json([
                'success' => true,
                'message' => 'Stock updated successfully',
                'data'    => $stock
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Stock not updated',
            ],404);
        }
    }
}
