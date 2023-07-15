<?php

namespace App\Http\Controllers;

use App\Features\Checkout\CheckoutCancelHandler;
use App\Features\Checkout\CheckoutCreateHandler;
use App\Features\Checkout\CheckoutStoreHandler;
use App\Features\Checkout\CheckoutSuccessHandler;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    //
    public function create(Request $request, CheckoutCreateHandler $handler)
    {
        return $handler->handle($request);
    }

    public function store(Request $request, CheckoutStoreHandler $handler)
    {
        return $handler->handle($request);
    }

    public function success(Request $request, Order $order, CheckoutSuccessHandler $handler) {
       return $handler->handle($request, $order);
    }

    public function cancel(Request $request, Order $order, CheckoutCancelHandler $handler) {
        return $handler->handle($request, $order);
    }
}
