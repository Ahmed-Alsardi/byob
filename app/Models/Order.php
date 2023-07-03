<?php

namespace App\Models;

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

    public function burgers() {
        return $this->hasMany(Burger::class);
    }

    public function user() {
        return $this->belongsTo(User::class, "customer_id");
    }
}
