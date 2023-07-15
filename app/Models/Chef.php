<?php

namespace App\Models;

use App\Helper\UserRole;
use App\Repository\UserRepository;

class Chef extends User
{

    public static function deleteChefWithId(mixed $chefId)
    {
        return self::query()
            ->find($chefId)
            ->delete();
    }

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

    public static function createChef($name, $email, $password) {
        return self::query()
            ->create([
                "name" => $name,
                "email" => $email,
                "password" => $password,
            ]);
    }

    public function updateInformation($name, $email)
    {
        return $this->update([
            "name" => $name ?? $this->name,
            "email" => $email ?? $this->email,
        ]);
    }
}
