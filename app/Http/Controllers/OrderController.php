<?php

namespace App\Http\Controllers;

use App\Helper\OrderStatus;
use App\Helper\UserRole;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Repository\OrderRepository;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = OrderRepository::getOrdersByUser();
        return view("orders", [
            "orders" => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $user = auth()->user();
        if ($order->customer_id != $user->id && $order->chef_id != $user->id && $user->role !== UserRole::ADMIN) {
            return redirect()->route("order.index");
        }
        if ($order->status === OrderStatus::REQUIRED_PAYMENT) {
            return redirect()->route("checkout.create");
        }
        $order->total_price = $order->total_price ?? OrderService::calculatePrice($order);
        return view("order", [
            "order" => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
