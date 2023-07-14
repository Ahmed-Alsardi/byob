<?php

namespace App\Models;

use App\Helper\UserRole;
use App\Repository\UserRepository;

class Chef extends User
{

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($chef) {
            $chef->forceFill([
                "role" => UserRepository::CHEF,
            ]);
        });
    }

    public static function booted() {
        static::addGlobalScope('chef', function ($q) {
            $q->where("role", "=", UserRepository::CHEF);
        });

    }

    public function orders()
    {
        return $this->hasMany(Order::class, "chef_id", "id");
    }

}
