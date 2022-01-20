<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Interfaces\OrderRepositoryInterface;

class OrderController extends Controller{

    private OrderRepositoryInterface $stockRepository;

    public function __construct(OrderRepositoryInterface $stockRepository) 
    {
        $this->stockRepository = $stockRepository;
    }

    public function index()
    {

    }

    public function placeOrder(Request $request)
    {
        return $this->stockRepository->placeOrder($request->all());
    }

}