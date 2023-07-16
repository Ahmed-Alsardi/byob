<?php

namespace App\Services;

use App\Helper\OrderStatus;
use App\Models\Location;
use App\Models\Order;
use App\Models\User;
use App\Repository\BurgerRepository;
use App\Repository\LocationRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;

class SessionServices
{

    public static function addSessionDataToUser(User $user)
    {
        if ($user->role != UserRepository::CUSTOMER) {
            return;
        }
        if (session()->exists("burgers")) {
            $order = OrderRepository::getUnpaidOrCreate($user);
            self::_addBurgersToUnpaidOrder($user, $order);
        }
        if (session()->exists("location")) {
            self::_addLocationToUser($user);
        }
    }

    private static function _addBurgersToUnpaidOrder(User $user, Order $order)
    {
        $burgers = session()->get("burgers");
        BurgerRepository::createBurgers($burgers, $order->id);
    }

    private static function _addLocationToUser(User $user)
    {
        $location = session()->get("location");
        LocationRepository::createLocation($user->id, $location);
    }


}
