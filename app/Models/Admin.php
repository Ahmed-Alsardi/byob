<?php

namespace App\Models;

use App\Helper\UserRole;
use App\Repository\UserRepository;

class Admin extends User
{

    protected static function boot()
    {
        parent::boot();

        static::creating(function($admin) {
            $admin->forceFill([
               "role" => UserRepository::ADMIN,
            ]);
        });
    }

    public static function booted()
    {
        static::addGlobalScope('admin', function ($q) {
            $q->where("role", "=", UserRepository::ADMIN);
        });
    }

    public static function getComplaintsByUserID($userId) {
        return Complaint::all();
    }
}
