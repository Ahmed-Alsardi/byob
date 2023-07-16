<?php

namespace App\Models;

use App\Helper\UserRole;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;

class Chef extends User
{

    public static function deleteChefWithId(mixed $chefId)
    {
        return self::query()
            ->find($chefId)
            ->delete();
    }

    public static function changeChefStatus($chefId, bool $status)
    {
        $chef = self::query()
            ->find($chefId);
        $chef?->changeChefAvailable($status);
    }

    public function changeChefAvailable(bool $status)
    {
        $this->available = $status;
        $this->save();
    }

    public static function getAllAvailableChefs()
    {
        return self::query()
            ->where("available", "=", true)
            ->where("unavailable_until", "<", now())
            ->get();
    }

    public static function updateChefAvailability($userId, mixed $unavailable_for)
    {
        return self::query()
            ->where("id", "=", $userId)
            ->update([
                "unavailable_until" => now()->addMinutes($unavailable_for)
            ]);
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

    public static function booted()
    {
        static::addGlobalScope('chef', function ($q) {
            $q->where("role", "=", UserRepository::CHEF);
        });

    }

    public function orders()
    {
        return $this->hasMany(Order::class, "chef_id", "id");
    }

    public static function createChef($name, $email, $password)
    {
        return self::query()
            ->create([
                "name" => $name,
                "email" => $email,
                "password" => $password,
            ]);
    }

    public function updateInformation($name, $email)
    {
        $this->name = $this->name ?? $name;
        $this->email = $this->email ?? $email;
        $this->save();
    }

    public function isAvailable()
    {
        return $this->available && $this->unavailable_until < now();
    }

}
