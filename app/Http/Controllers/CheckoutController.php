<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repository\BurgerRepository;
use App\Repository\LocationRepository;
use App\Repository\OrderRepository;
use App\Services\EmailNotificationService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    //
    public function create()
    {
        if (auth()->check()) {
            $order = OrderRepository::getUnpaidOrder(auth()->user())->first();
            if (!$order) {
                return redirect()->route("burgers.index");
            }
//            OrderService::assignOrderToChef($order);
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
        if ($totalPrice <= 0) {
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
        $burgerCounts = (int) ($totalPrice / OrderService::BURGER_PRICE);
        if (OrderService::assignOrderToChef($order)) {
            return auth()
                ->user()
                ->checkout([env("STRIPE_PRICE_ID") => $burgerCounts], [
                    "success_url" => route("checkout.success", $order) . "?session_id={CHECKOUT_SESSION_ID}",
                    "cancel_url" => route("checkout.cancel", $order),
                ]);
        } else {
            abort(400, "No available chefs");
        }
    }

    public function success(Request $request, Order $order) {
        $checkoutSession = $request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));
        OrderService::savePaymentIntentId($order, $checkoutSession->payment_intent);
        if ($order->customer_id !== $request->user()->id) {
            abort(403);
        }
//        if ($or)
        EmailNotificationService::sendReceiptEmail($order);
        return redirect()->route("order.index");
    }

    public function cancel(Request $request, Order $order) {
        if ($order->customer_id !== $request->user()->id) {
            abort(403);
        }
        OrderService::rollbackChefAssignment($order);
        return redirect()->route("burgers.index");
    }
}
