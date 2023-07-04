<?php

namespace App\Models;

use App\Helper\UserRole;

class Admin extends User
{

    protected static function boot()
    {
        parent::boot();

        static::creating(function($admin) {
            $admin->forceFill([
               "role" =>UserRole::ADMIN,
            ]);
        });
    }

    public static function booted()
    {
        static::addGlobalScope('admin', function ($q) {
            $q->where("role", "=", UserRole::ADMIN);
        });
    }
}
