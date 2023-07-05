<?php

namespace App\Services;

use App\Helper\OrderStatus;
use App\Models\Chef;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{

    const ORDER_TIME = 5;
    const BURGER_PRICE = 1000;

    public static function assignOrderToChef($order): bool
    {
        return DB::transaction(function () use ($order) {
            try {
                $chef = self::_getChef();
            } catch (\Exception $e) {
                return false;
            }
            $chef->available = false;
            $order->status = OrderStatus::IN_PROGRESS;
            $order->chef_id = $chef->id;
            $order->chef_assigned_at = now();
            $customerLocation = Customer::query()->where("id", "=", $order->customer_id)->first()->location;
            $order->city = $customerLocation->city;
            $order->street = $customerLocation->street;
            $order->house_number = $customerLocation->house_number;
            $order->save();
            $chef->save();
            return true;
        });
    }

    public static function rollbackChefAssignment($order): bool
    {
        return DB::transaction(function () use ($order) {
            $chef = $order->chef;
            $chef->available = true;
            $order->status = OrderStatus::REQUIRED_PAYMENT;
            $order->chef_assigned_at = null;
            $order->chef_id = null;
            $order->city = null;
            $order->street = null;
            $order->house_number = null;
            $order->save();
            $chef->save();
            return true;
        });
    }

    public static function calculatePrice(Order $order = null, $burgers = null): float
    {
        if ($order) {
            $quantity = $order->burgers->count();
        } else if ($burgers) {
            $quantity = count($burgers);
        } else {
            return -1;
        }
        return $quantity * self::BURGER_PRICE;
    }

    public static function calculateAndSavePrice($order): float
    {
        $total_price = self::calculatePrice($order);
        if ($total_price <= 0) {
            return -1;
        }
        $order->total_price = $total_price;
        $order->save();
        return $total_price;
    }

    /**
     * @throws \Exception
     */
    private static function _getChef()
    {
        $chefs = Chef::query()
            ->where("available", "=", true)
            ->get();
        if ($chefs->count() == 0) {
            throw new \Exception("No chefs available");
        }
        if ($chefs->count() == 1) {
            return $chefs->first();
        }
        // get the chef of the last order
        $lastOrder = Order::query()
            ->where("chef_id", "!=", null)
            ->orderBy("chef_assigned_at", "desc")
            ->first();
        if ($lastOrder == null) {
            $chef = $chefs->first();
            if ($chef == null) {
                throw new \Exception("No chefs available");
            }
            return $chef;
        }
        $chef = $chefs
            ->where("id", ">", $lastOrder->chef_id)
            ->sortBy("id")
            ->first();
//        dd($chef);
        // sort the chefs based on the unavailability time
        if ($chef == null) {
            $chef = $chefs->first();
            if ($chef == null) {
                throw new \Exception("No chefs available");
            }
        }
        return $chef;
    }
}
