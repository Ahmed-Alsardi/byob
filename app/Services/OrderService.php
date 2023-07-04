<?php

namespace App\Services;

use App\Helper\OrderStatus;
use App\Models\Chef;
use Illuminate\Support\Facades\DB;

class OrderService
{

    const ORDER_TIME = 5;
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
            if (!$chef) {
                return false;
            }
            $chef->unavailable_until = now()->addMinutes(self::ORDER_TIME);
            $order->status = OrderStatus::IN_PROGRESS;
            $order->chef_id = $chef->id;
            $order->save();
            $chef->save();
            return true;
        });


    }

}
