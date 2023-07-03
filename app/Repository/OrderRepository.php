<?php

namespace App\Repository;

use App\Http\Helper\OrderStatus;
use App\Models\Order;
use App\Models\User;
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

}
