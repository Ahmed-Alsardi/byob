<?php

namespace App\Features\Checkout;

use App\Repository\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutStoreHandler
{

    public function handle(Request $request) {
        $userId = $request->user()->id;
        $data = OrderRepository::getCustomerUnpaidOrderForCheckout($userId);
        if (!$data) {
            abort(500, "Error happend when getting Order data");
        }
        if (OrderService::assignOrderToChef($data["orderId"])) {
            return auth()
                ->user()
                ->checkout([env("STRIPE_PRICE_ID") => $data['burgersCount']], [
                    "success_url" => route("checkout.success", $data['orderId']) . "?session_id={CHECKOUT_SESSION_ID}",
                    "cancel_url" => route("checkout.cancel", $data['orderId']),
                ]);
        } else {
            abort(503, "No available chefs");
        }
    }
}
