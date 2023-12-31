<?php

namespace App\Models;

use App\Repository\BurgerCustomizationRepository;
use App\Repository\BurgerRepository;
use App\Repository\OrderRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "customer_id",
        "chef_id",
        "status",
    ];

    public static function getOrderById($order_id)
    {
        return self::query()
            ->where("id", "=", $order_id)
            ->first();
    }

    public static function getLastOrder()
    {
        return self::query()
            ->where("chef_id", "!=", null)
            ->orderBy("chef_assigned_at", "desc")
            ->first();
    }

    public function burgers()
    {
        return $this->hasMany(Burger::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, "customer_id");
    }

    public function chef()
    {
        return $this->belongsTo(User::class, "chef_id");
    }

    public function burgersView()
    {
        return $this->burgers->map(fn($burger) => BurgerRepository::convertBurgerToReadableIngredient($burger));
    }

    public function location()
    {
        return [
            "city" => $this->city,
            "street" => $this->street,
            "house_number" => $this->house_number,
        ];
    }

    public function complaint()
    {
        return $this->hasOne(Complaint::class);
    }

    public function refund()
    {
        return $this->customer->refund($this->payment_intent_id);
    }

    public static function getCustomerOrderWithStatus($userId, $orderStatus)
    {
        return Order::query()
            ->where("customer_id", "=", $userId)
            ->where("status", $orderStatus)
            ->latest()
            ->first();
    }

    public function deleteBurgers()
    {
        return $this->burgers()->delete();
    }

    public static function createOrderWithStatus($userId, $orderStatus)
    {
        return Order::create([
            "customer_id" => $userId,
            "status" => $orderStatus,
        ]);
    }

    public function savePaymentIntentId($payment_intent)
    {
        $this->payment_intent_id = $payment_intent;
        $this->save();
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        $this->save();
        return $this;
    }

    // This is used in OrderRepository::getOrdersByUser and the user is not admin
    public static function getOrdersByUser($columnName, $userId): Collection|array
    {
        return Order::query()
            ->where($columnName, "=", $userId)
            ->get();
    }

    // This is used in OrderRepository::getOrdersByUser and the user is admin
    public static function getAllOrders(): Collection|array
    {
        return Order::all();
    }

    public function completeOrder(string $status)
    {
        $this->status = $status;
        $this->completed_at = now();
        $this->save();
    }

    public function getChef()
    {
        return $this->chef;
    }

    public function rollbackChefAssignment()
    {
        $this->status = OrderRepository::REQUIRED_PAYMENT;
        $this->chef_id = null;
        $this->chef_assigned_at = null;
        $this->city = null;
        $this->street = null;
        $this->house_number = null;
        $this->save();
    }

    public function assignChef($chefId, $location)
    {
        $this->status = OrderRepository::IN_PROGRESS;
        $this->chef_id = $chefId;
        $this->chef_assigned_at = now();
        $this->city = $location->city;
        $this->street = $location->street;
        $this->house_number = $location->house_number;
        $this->save();
    }
}
