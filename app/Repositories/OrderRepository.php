<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\StockRepositoryInterface;
use App\Interfaces\VehicleRepositoryInterface;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Stock;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface 
{
    protected $vehicleType = [
        'App\\Models\\Motorcycle',
        'App\\Models\\Car'
    ];
    protected StockRepositoryInterface $stockRepository;
    protected VehicleRepositoryInterface $vehicleRepository;

    public function __construct(StockRepositoryInterface $stockRepository, VehicleRepositoryInterface $vehicleRepository)
    {
        $this->stockRepository = $stockRepository;
        $this->vehicleRepository = $vehicleRepository;
    }
    
    public function getAllOrders() 
    {
        try {
            $stock = Order::with('vehicle')->get();

            if (!count($stock)) {
                return false;
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Order found',
                'data'    => $stock
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ],404);
        }
    }

    public function getAllOrderMotorcycles()
    {
        try {
            $stock = Order::with('vehicle')
            ->whereHas('vehicle', function($q){
                $q->where('vehicle_type', $this->vehicleType[0]);
            })
            ->get();

            if (!count($stock)) {
                throw new Exception();
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Order found',
                'data'    => $stock
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ],404);
        }
    }

    public function getAllOrderCars()
    {
        try {
            $stock = Order::with('vehicle')
            ->whereHas('vehicle', function($q){
                $q->where('vehicle_type', $this->vehicleType[1]);
            })
            ->get();

            if (!count($stock)) {
                throw new Exception();
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Order found',
                'data'    => $stock
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ],404);
        }
    }
    
    public function placeOrder(array $orderWithDetails) 
    {
        DB::beginTransaction();
        $subtotal = 0;
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->subtotal = $subtotal;
        $order->save();
        try {
            //code...
            foreach ($orderWithDetails as $key => $value) {
                $orderDetail = new OrderDetail;
                DB::table('order_details')
                ->insert([
                    'order_id' => $order->id,
                    'stock_id' => $value["stock_id"],
                    'qty' => $value["qty"],
                ]);
                $stock = Stock::findOrFail($value["stock_id"]);
                if ($stock->qty<$value["qty"]) {
                    throw new Exception('Stock insufficient', 1);
                }
                DB::table('stocks')->where('id', $value["stock_id"])
                ->update([
                    'qty' => $stock->qty-$value["qty"],
                ]);
                $subtotal += $stock->vehicle->price;
            }
            $order->subtotal = $subtotal;
            $order->save();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully',
                'order' => $order->first(),
            ], 200);
        } catch (\Throwable $th) {
            Order::destroy($order->id);
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 409);
            //throw $th;
        }
        

    }

    public function updateOrder($OrderId, array $newDetails) 
    {
        try {
            $stock = Order::whereId($OrderId)->update($newDetails);

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully',
                'data'    => $stock
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Order not updated',
            ],404);
        }
    }
}
