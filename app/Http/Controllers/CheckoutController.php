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
        $this->authorize('create-checkout');
        return $handler->handle($request);
    }

    public function store(Request $request, CheckoutStoreHandler $handler)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }
//        $this->authorize('store-checkout');
        return $handler->handle($request);
    }

    public function success(Request $request, Order $order, CheckoutSuccessHandler $handler)
    {
        $this->authorize('success-checkout', $order);
        return $handler->handle($request, $order);
    }

    public function cancel(Request $request, Order $order, CheckoutCancelHandler $handler)
    {
        $this->authorize('cancel-checkout', $order);
        return $handler->handle($request, $order);
    }
}
