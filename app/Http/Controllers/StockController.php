<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\StockRepositoryInterface;

class StockController extends Controller{

    private StockRepositoryInterface $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository) 
    {
        $this->stockRepository = $stockRepository;
    }

    public function index()
    {
        return $this->stockRepository->getAllStocks();
    }
    public function getStockCars()
    {
        return $this->stockRepository->getAllStockCars();
    }

    public function getStockMotorcycles()
    {
        return $this->stockRepository->getAllStockMotorcycles();
    }
    public function getStockByVehicleId($vehicleId)
    {
        return $this->stockRepository->getStockByVehicleId($vehicleId);
    }
    public function getStockById($stockId)
    {
        return $this->stockRepository->getStockById($stockId);
    }
    public function storeUpdate(Request $request)
    {
        $this->validate($request,[
            'vehicle_id' => 'required',
            'qty' => 'required',
        ]);
        return $this->stockRepository->updateStock($request->vehicle_id, $request->except(['vehicle_id']));
    }
}