<?php

namespace App\Http\Controllers;

use App\Repository\BurgerRepository;
use App\Repository\LocationRepository;
use App\Repository\OrderRepository;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    //
    public function create()
    {
//        dd(session()->all());
        if (auth()->check()){
            $order = OrderRepository::getUnpaidOrder(auth()->user())->first();
            if (!$order) {
                return redirect()->route("home");
            }
            $location = LocationRepository::getUserLocation(auth()->user());
            if (!$location) {
                return redirect()->route("home");
            }
            $burgers = $order->burgers;
            $burgers->map(fn($burger) => BurgerRepository::convertFromEntityToArray($burger));
        } else {
            if (!session()->exists("burgers")) {
                return redirect()->route("home");
            }
            if (!session()->exists("location")) {
                return redirect()->route("home");
            }
            $burgers = session()->get("burgers");
            $location = session()->get("location");
        }
        return view("checkout", [
            "burgers" => $burgers,
            "location" => $location,
        ]);
    }

    public function store()
    {
        if (!auth()->check()) {
            return redirect()->route("login");
        }
    }
}