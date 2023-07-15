<?php

namespace App\Features\Checkout;


use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutCancelHandler
{

    public function handle(Request $request, Order $order) {
        OrderService::rollbackChefAssignment($order);
        return redirect()->route("burgers.index");
    }
}
