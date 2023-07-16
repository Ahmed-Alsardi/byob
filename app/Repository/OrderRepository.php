<?php

namespace App\Repository;

use App\Models\Chef;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    const COLUMN_NAME = 'column_name';
    const METHOD_NAME = 'method_name';

    const ROLE_ORDER = [
        UserRepository::CUSTOMER => [
            self::COLUMN_NAME => 'customer_id',
            self::METHOD_NAME => 'getOrdersByUser'
        ],
        UserRepository::CHEF => [
            self::COLUMN_NAME => 'chef_id',
            self::METHOD_NAME => 'getOrdersByUser'
        ],
        UserRepository::ADMIN => [
            self::COLUMN_NAME => null,
            self::METHOD_NAME => 'getAllOrders'
        ],
    ];

    public static function getCustomerUnpaidOrder($userId)
    {
        return Order::getCustomerOrderWithStatus($userId, self::REQUIRED_PAYMENT);
    }

    public static function getUnpaidOrCreate($user, $removeExistingBurgers = false)
    {
        $order = Order::getCustomerOrderWithStatus($user, self::REQUIRED_PAYMENT);
        if ($order && $removeExistingBurgers) {
            $order->burgers->map(fn($burger) => $burger->forceDelete());
        }
        return $order ?? Order::query()
            ->create([
                "customer_id" => $user->id,
                "status" => OrderRepository::REQUIRED_PAYMENT,
            ]);
    }

    public static function getOrdersByUser($user)
    {
        if (array_key_exists($user->role, self::ROLE_ORDER)) {
            $method = self::ROLE_ORDER[$user->role][self::METHOD_NAME];
            $columnName = self::ROLE_ORDER[$user->role][self::COLUMN_NAME];
            return Order::$method($columnName, $user->id);
        }
        return null;
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

    public static function calculatePrice($burgers)
    {
        if (!$burgers) {
            return 0;
        }
        if ($burgers instanceof Collection) {
            $count = $burgers->count();
        } else {
            $count = count($burgers);
        }
        return $count* self::BURGER_PRICE;
    }

    private static function _getBurgersFromOrders($order) {
        if ($order && $order->burgers) {
            return $order->burgers->map(fn($burger) => BurgerRepository::convertBurgerToReadableIngredient($burger));
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

    public static function resolveComplaintOrder(mixed $refund, mixed $order_id)
    {
        $order = Order::getOrderById($order_id);
        if ($refund) {
            $result = $order->refund();
            if ($result['status'] == 'succeeded') {
                $order->updateStatus(self::REFUNDED);
            } else {
                $order->updateStatus(self::REFUND_FAILED);
                throw new \Exception("Refund failed");
            }
        } else {
            $order->updateStatus(self::REFUND_REJECTED);
        }
    }

    public static function completeOrder($chefId, Order $order)
    {
        return DB::transaction(function () use ($chefId, $order) {
            try {
                $order->completeOrder(self::COMPLETED);
                Chef::changeChefStatus($chefId, true);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        });
    }

    public static function orderHasComplaint(Order $order)
    {
        return (bool)$order->complaint;
    }

    public static function changeOrderStatus(Order $order, string $status)
    {
        $order->updateStatus($status);
    }

}
