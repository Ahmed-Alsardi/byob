<?php

namespace App\Repository;

use App\Helper\OrderStatus;
use App\Helper\UserRole;
use App\Models\Customer;
use App\Models\Order;
use App\Repository\CustomerRepository\CustomerRepository;
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

    const BURGER_PRICE = 1000;

    public static function getCustomerUnpaidOrder($userId): array|Collection
    {
        return Order::getCustomerOrderWithStatus($userId, self::REQUIRED_PAYMENT);
    }

    public static function getUnpaidOrCreate($user, $removeExistingBurgers = false)
    {
        $order = Order::getCustomerOrderWithStatus($user)->first();
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

    public static function getCustomerBurgers($userId = null)
    {
        if ($userId) {
            $order = Order::getCustomerOrderWithStatus($userId, self::REQUIRED_PAYMENT);
            return self::_getBurgersFromOrders($order);
        } else {
            if (session()->exists(BurgerRepository::BURGER_SESSION_NAME)){
                return session()->get(BurgerRepository::BURGER_SESSION_NAME);
            }
        }
        return null;
    }

    public static function saveCustomerBurgers(mixed $burgers, $userId = null)
    {
        if ($userId) {
            $order = Order::getCustomerOrderWithStatus($userId, self::REQUIRED_PAYMENT);
            if ($order){
                $order->deleteBurgers();
            } else {
                $order = Order::createOrderWithStatus($userId, self::REQUIRED_PAYMENT);
            }
            BurgerRepository::createBurgers($burgers, $order->id);
        } else {
            BurgerRepository::createBurgers($burgers);
        }
    }

    public static function calculatePrice(array $burgers)
    {
        if (!$burgers) {
            return 0;
        }
        return count($burgers) * self::BURGER_PRICE;
    }

    private static function _getBurgersFromOrders($order) {
        if ($order && $order->burgers) {
            return BurgerRepository::convertFromEntityToArray($order->burgers);
        }
        return null;
    }

    public static function getCustomerUnpaidOrderForCheckout($userId)
    {
        $order = self::getCustomerUnpaidOrder($userId);
        if (!$order) {
            return null;
        }
        $burgersCount = count(self::_getBurgersFromOrders($order));
        if (!$burgersCount) {
            return null;
        }
        return [
            "orderId" => $order->id,
            "burgersCount" => $burgersCount,
        ];
    }

    public static function savePaymentIntentId(Order $order, $payment_intent)
    {
       $order->savePaymentIntentId($payment_intent);
    }

}
