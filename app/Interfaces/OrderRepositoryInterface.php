<?php

namespace App\Interfaces;

interface OrderRepositoryInterface 
{
    public function getAllOrders();
    public function getAllOrderCars();
    public function getAllOrderMotorcycles();
    public function placeOrder(array $orderWithDetails);
}
