<?php

namespace App\Features\Checkout;


use App\Models\Order;
use App\Repository\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutCancelHandler
{

    public function handle(Request $request, Order $order) {
        OrderRepository::rollbackChefAssignment($order);
        return redirect()->route("burgers.index");
    }
}
