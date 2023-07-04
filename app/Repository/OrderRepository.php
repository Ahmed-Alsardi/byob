<?php

namespace App\Repository;

use App\Helper\OrderStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{

    public static function getUnpaidOrder($user): array|Collection
    {
        return Order::query()
            ->where("customer_id", "=", $user->id)
            ->where("status", "=", OrderStatus::REQUIRED_PAYMENT)
            ->get();
    }

    public static function getUnpaidOrCreate($user, $removeExistingBurgers=false)
    {
        $order = self::getUnpaidOrder($user)->first();
        if ($order && $removeExistingBurgers) {
            $order->burgers->map(fn($burger) => $burger->forceDelete());
        }
        return $order ?? Order::query()
            ->create([
                "customer_id" => $user->id,
                "status" => OrderStatus::REQUIRED_PAYMENT,
            ]);
    }

    public static function getOrdersByUser(int $userId): Collection
    {
        return Order::query()
            ->where("customer_id", "=", $userId)
//            ->where("status", "!=", OrderStatus::REQUIRED_PAYMENT)
            ->get();
    }

}
