<?php

namespace App\Services;

use App\Helper\OrderStatus;
use App\Models\Chef;
use App\Models\Customer;
use App\Models\Order;
use App\Repository\ComplaintRepository;
use App\Repository\OrderRepository;
use Illuminate\Support\Facades\DB;

class OrderService
{

    public static function assignOrderToChef($order): bool
    {
        return DB::transaction(function () use ($order) {
            try {
                $chef = self::_getChef();
            } catch (\Exception $e) {
                return false;
            }
            $chef->available = false;
            $order->status = OrderRepository::IN_PROGRESS;
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
            $order->status = OrderRepository::REQUIRED_PAYMENT;
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

    /**
     * @throws \Exception
     */
    private static function _getChef()
    {
        $chefs = ChefRepository::getAllAvailableChef();
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
