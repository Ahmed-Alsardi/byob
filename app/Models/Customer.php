<?php

namespace App\Models;

use App\Helper\UserRole;

class Customer extends User
{

    protected static function boot()
    {
        parent::boot();
        static::creating([
            "role" => UserRole::CUSTOMER,
        ]);
    }

    protected static function booted()
    {
        static::addGlobalScope('customer', function ($q) {
            $q->where("role", "=", UserRole::CUSTOMER);
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class, "customer_id", "id");
    }

    public function location()
    {
        return $this->hasOne(Location::class, "user_id", "id");
    }

}
