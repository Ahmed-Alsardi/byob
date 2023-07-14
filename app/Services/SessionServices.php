<?php

namespace App\Services;

use App\Helper\OrderStatus;
use App\Models\Location;
use App\Models\Order;
use App\Models\User;
use App\Repository\BurgerRepository;
use App\Repository\LocationRepository;
use App\Repository\OrderRepository;

class SessionServices
{

    public static function addSessionDataToUser(User $user)
    {
        if (session()->exists("burgers")) {
            $order = OrderRepository::getUnpaidOrCreate($user);
            self::_addBurgersToUnpaidOrder($user, $order);
        }
        if (session()->exists("location")) {
            self::_addLocationToUser($user);
        }
    }

    private static function _existUnpaidOrder(User $user)
    {
        $orders = OrderRepository::getUnpaidOrder($user)->first();
        return (bool)$orders;
    }

    private static function _createNewOrder(User $user)
    {
        $order = Order::query()->create([
            "customer_id" => $user->id,
            "status" => OrderRepository::REQUIRED_PAYMENT,
        ]);
        $burgers = session()->get("burgers");
        BurgerRepository::createBurger($burgers, $order->id);
    }

    private static function _addBurgersToUnpaidOrder(User $user, Order $order)
    {
        $burgers = session()->get("burgers");
        BurgerRepository::createBurger($burgers, $order->id);
    }

    private static function _addLocationToUser(User $user)
    {
        $location = Location::query()
            ->where("user_id", "=", $user->id)
            ->exists();
        if ($location) {
            return;
        }
        $location = session()->get("location");
        LocationRepository::createLocation($location, $user->id);
    }


}
