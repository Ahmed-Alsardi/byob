<?php

namespace App\Services;

use App\Models\Chef;
use Illuminate\Database\Eloquent\Collection;

class ChefRepository
{


    public static function getAllChefs(): Collection
    {
        return Chef::all();
    }

    public static function getAllAvailableChef(): Collection
    {
        return Chef::query()
            ->where("available", "=", true)
            ->where("unavailable_until", "<", now())
            ->get();
    }

    public static function createChef(mixed $name, mixed $email, mixed $password)
    {
        return Chef::query()
            ->create([
                "name" => $name,
                "email" => $email,
                "password" => $password,
            ]);
    }

    public static function updateAvailability(mixed $user, mixed $unavailable_for)
    {
        return Chef::query()
            ->where("id", "=", $user->id)
            ->update([
                "unavailable_until" => now()->addMinutes($unavailable_for)
            ]);
    }
}
