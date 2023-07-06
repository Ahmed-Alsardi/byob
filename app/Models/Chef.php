<?php

namespace App\Models;

use App\Helper\UserRole;

class Chef extends User
{

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($chef) {
            $chef->forceFill([
                "role" => UserRole::CHEF,
            ]);
        });
    }

    public static function booted() {
        static::addGlobalScope('chef', function ($q) {
            $q->where("role", "=", UserRole::CHEF);
        });

    }

    public function orders()
    {
        return $this->hasMany(Order::class, "chef_id", "id");
    }

    public function isAvailable(): bool {
        return $this->available && $this->unavailable_until < now();
    }
}
