<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_message',
        'admin_message',
        'admin_id',
        'refund'
    ];

  public static function createComplaint(mixed $id, string $customerMessage)
  {
      return Complaint::create([
          'order_id' => $id,
          'customer_message' => $customerMessage
      ]);
  }

  public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->order->customer;
    }

    public function is_resolved(): bool
    {
        return $this->refund !== null;
    }

    public function resolve($refund, $admin_message, $adminId){
        $this->refund = $refund;
        $this->admin_message = $admin_message;
        $this->admin_id = $adminId;
        $this->save();
        return $this;
    }
}
