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

    public static function getOrdersByUser($columnName, $userId): Collection|array
    {
        return Order::query()
            ->where($columnName, "=", $userId)
            ->get();
    }

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
        $this->update([
            'status' => OrderRepository::REQUIRED_PAYMENT,
            'chef_id' => null,
            'chef_assigned_at' => null,
            'city' => null,
            'street' => null,
            'house_number' => null,
        ]);
    }

    public function assignChef($chefId, $location)
    {
        $this->update([
            "status" => OrderRepository::IN_PROGRESS,
            "chef_id" => $chefId,
            "chef_assigned_at" => now(),
            "city" => $location->city,
            "street" => $location->street,
            "house_number" => $location->house_number,
        ]);
    }
}
