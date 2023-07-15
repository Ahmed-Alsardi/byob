<?php

namespace App\Features\Checkout;


use App\Repository\LocationRepository;
use App\Repository\OrderRepository;
use Illuminate\Http\Request;

class CheckoutCreateHandler
{

    public function handle(Request $request) {
        $userId = $request->user()?->id;
        $burgers = OrderRepository::getCustomerBurgers($userId);
        if (!$burgers) {
            return redirect()->route("burgers.index");
        }
        $location = LocationRepository::getCustomerLocation($userId);
        if ($location) {
            return redirect()->route("location.create");
        }
        $totalPrice = OrderRepository::calculatePrice($burgers);
        return view("checkout", [
            "burgers" => $burgers,
            "location" => $location,
            "totalPrice" => $totalPrice,
        ]);
    }
}
