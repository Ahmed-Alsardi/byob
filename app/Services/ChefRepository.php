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
}
