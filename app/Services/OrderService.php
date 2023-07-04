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
    public static function assignOrderToChef($order): bool {
        return DB::transaction(function () use ($order) {
            $chefs = Chef::query()
                ->orWhere("unavailable_until", "<", now())
                ->orWhere("unavailable_until", "=", null)
                ->get();
            // sort the chefs based on the unavailability time
            $chefs = $chefs->map(function ($c) {
                $c->unavailable_until = $c->unavailable_until ?? now()->subDay();
                return $c;
            });
            $chefs = $chefs->sortBy("unavailable_until");
            $chef = $chefs->first();
            if ($chef == null) {
                return false;
            }
            $chef->unavailable_until = now()->addMinutes(self::ORDER_TIME);
            $order->status = OrderStatus::IN_PROGRESS;
            $order->chef_id = $chef->id;
            $customerLocation = Customer::query()->where("id", "=", $order->customer_id)->first()->location;
            $order->city = $customerLocation->city;
            $order->street = $customerLocation->street;
            $order->house_number = $customerLocation->house_number;
            $order->save();
            $chef->save();
            return true;
        });
    }

    public static function rollbackChefAssignment($order): bool {
        return DB::transaction(function () use ($order) {
            $chef = $order->chef;
            $chef->unavailable_until = now()->subMinutes(self::ORDER_TIME);
            $order->status = OrderStatus::REQUIRED_PAYMENT;
            $order->chef_id = null;
            $order->city = null;
            $order->street = null;
            $order->house_number = null;
            $order->save();
            $chef->save();
            return true;
        });
    }

    public static function calculatePrice(Order $order = null, $burgers = null): float {
        if ($order){
            $quantity = $order->burgers->count();
        } else if($burgers) {
            $quantity = count($burgers);
        } else {
            return -1;
        }
        return $quantity * self::BURGER_PRICE;
    }

    public static function calculateAndSavePrice($order): float {
        $total_price = self::calculatePrice($order);
        if ($total_price <= 0) {
            return -1;
        }
        $order->total_price = $total_price;
        $order->save();
        return $total_price;
    }

}
