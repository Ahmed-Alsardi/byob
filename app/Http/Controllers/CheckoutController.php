<?php

namespace App\Http\Controllers;

use App\Repository\BurgerRepository;
use App\Repository\LocationRepository;
use App\Repository\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    //
    public function create()
    {
        if (auth()->check()){
            $order = OrderRepository::getUnpaidOrder(auth()->user())->first();
            if (!$order) {
                return redirect()->route("burgers.index");
            }
            $location = LocationRepository::getUserLocation(auth()->user());
            if (!$location) {
                return redirect()->route("location.create");
            }
            $burgers = $order->burgers;
            $burgers = $burgers->map(fn($burger) => BurgerRepository::convertFromEntityToArray($burger));
        } else {
            if (!session()->exists("burgers")) {
                return redirect()->route("burgers.index");
            }
            if (!session()->exists("location")) {
                return redirect()->route("location.create");
            }
            $burgers = session()->get("burgers");
            $location = session()->get("location");
        }
        $totalPrice = OrderService::calculatePrice(null, $burgers);
        if ($totalPrice <= 0 ) {
            return redirect()->route("burgers.index");
        }
        return view("checkout", [
            "burgers" => $burgers,
            "location" => $location,
            "totalPrice" => $totalPrice,
        ]);
    }

    public function store()
    {
        if (!auth()->check()) {
            return redirect()->route("login");
        }
        $order = OrderRepository::getUnpaidOrder(auth()->user())->first();
        $totalPrice = OrderService::calculateAndSavePrice($order);
        if ($totalPrice <= 0) {
            return redirect()->route("burgers.index");
        }
        if (OrderService::assignOrderToChef($order)){
            return redirect()->route("order.show", $order);
        } else {
            abort(400, "No available chefs");
        }
    }
}
