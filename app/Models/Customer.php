<?php

namespace App\Models;

use App\Helper\UserRole;
use App\Repository\UserRepository;

class Customer extends User
{

    protected static function boot()
    {
        parent::boot();
        static::creating([
            "role" => UserRepository::CUSTOMER,
        ]);
    }

    protected static function booted()
    {
        static::addGlobalScope('customer', function ($q) {
            $q->where("role", "=", UserRepository::CUSTOMER);
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
