<?php

namespace App\Features\Checkout;


use App\Models\Order;
use App\Repository\OrderRepository;
use App\Services\EmailNotificationService;
use Illuminate\Http\Request;

class CheckoutSuccessHandler
{

    public function handle(Request $request, Order $order) {
        $checkoutSession = $request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));
        OrderRepository::savePaymentIntentId($order, $checkoutSession->payment_intent);
        EmailNotificationService::sendReceiptEmail($order);
        return redirect()->route("order.index");
    }
}
