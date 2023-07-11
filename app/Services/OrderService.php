<?php

namespace App\Services;

use App\Helper\OrderStatus;
use App\Models\Chef;
use App\Models\Customer;
use App\Models\Order;
use App\Repository\ComplaintRepository;
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
        $chefs = ChefRepository::getAllAvailableChef();
        /**
         * just check if $chefs is null throw exception
         * Done
         */
        if (!$chefs) {
            throw new \Exception("No chefs available");
        }
        if ($chefs->count() == 0) {
            throw new \Exception("No chefs available");
        }
        if ($chefs->count() == 1) {
            return $chefs->first();
        }
        // get the chef of the last order
        /**
         * TODO
         * use can also use latest() method
         * Done
         */
        $lastOrder = Order::query()
            ->where("chef_id", "!=", null)
            ->latest("chef_assigned_at")
            ->first();
        /**
         * TODO
         * you can simple use if ($lastOrder)
         */
        /**
         * TODO
         * on line no 89 you already handled this like if no chefs available so your first condition throw exception no need of this condition
         * ===============================
         * The orders should be assign to chefs in round robin fashion, I need to get the last chef who was assigned
         * to the last order to get the next chef who should be assigned to this order.
         * If the last order was null, it means that this is the first order for the whole application, so assign it to the first chef.
         * otherwise, get the next chef whose id is greater than the last chef id, if not found, that mean we need
         * circle back to the first chef.
         */
        if (!$lastOrder) {
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
        /**
         * TODO same goes here
         * Done
         */
        if (!$chef) {
            $chef = $chefs->first();
            if ($chef == null) {
                throw new \Exception("No chefs available");
            }
        }
        return $chef;
    }

    public static function completeOrder($chef, Order $order)
    {
        /**
         * TODO
         * why we are using this method for update
         * create one update method for this pass data to to update function in which first check order exists if exists simply update and return
         * ================================
         * This method will not be called unless the order and the chef are both available
         */
        return DB::transaction(function () use ($chef, $order) {
            try {
                $chef->available = true;
                $order->status = OrderStatus::COMPLETED;
                $order->completed_at = now();
                $order->save();
                $chef->save();
                return true;
            } catch (\Exception $e) {
                return false;
            }
        });
    }

    public static function complaintOrder(Order $order, string $message)
    {
        return DB::transaction(function () use ($order, $message) {
            $order->status = OrderStatus::COMPLAINT;
            $order->save();
            return ComplaintRepository::createComplaint($order, $message);
        });
    }

    public static function savePaymentIntentId(Order $order, $payment_intent): void
    {
        $order->payment_intent_id = $payment_intent;
        $order->save();
    }
}
