<?php

namespace App\Repository;

use App\Helper\OrderStatus;
use App\Helper\UserRole;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class OrderRepository
{

    const REQUIRED_PAYMENT = "required_payment";
    const COMPLAINT = "complaint";
    const IN_PROGRESS = "in_progress";
    const COMPLETED = "completed";
    const REFUNDED = "refunded";
    const REFUND_REJECTED = "refund_rejected";
    const REFUND_FAILED = "refund_failed";

    public static function getUnpaidOrder($user): array|Collection
    {
        return Order::query()
            ->where("customer_id", "=", $user->id)
            ->where("status", "=", OrderRepository::REQUIRED_PAYMENT)
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
                "status" => OrderRepository::REQUIRED_PAYMENT,
            ]);
    }

    public static function getOrdersByUser(): Collection
    {
        $user = auth()->user();
        if ($user->role === UserRole::CUSTOMER) {
            return Order::query()
                ->where("customer_id", "=", $user->id)
                ->with("burgers")
                ->get();
        } else if ($user->role === UserRole::ADMIN) {
            return Order::with('burgers')->get();
        } else {
            return Order::query()
                ->where("chef_id", "=", $user->id)
                ->with("burgers")
                ->get();
        }
    }

}
