<?php

namespace App\Http\Helper;

use App\Models\Location;
use App\Models\Order;
use App\Models\User;
use App\Repository\BurgerRepository;
use App\Repository\LocationRepository;
use App\Repository\OrderRepository;

class LoginHelper
{

    public static function addSessionDataToUser(User $user)
    {
        if (session()->exists("burgers")) {
            if (self::_existUnpaidOrder($user)) {
                self::_addBurgersToUnpaidOrder($user);
            } else {
                self::_createNewOrder($user);
            }
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
            "status" => OrderStatus::REQUIRED_PAYMENT,
        ]);
        $burgers = session()->get("burgers");
        BurgerRepository::createBurger($burgers, $order->id);
    }

    private static function _addBurgersToUnpaidOrder(User $user)
    {
        $order = OrderRepository::getUnpaidOrder($user)->first();
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
