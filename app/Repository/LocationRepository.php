<?php

namespace App\Repository;

use App\Models\Location;

class LocationRepository
{

    public static function createLocation(array $location, int $userId = null): void
    {
        if ($userId) {
            Location::query()->create([
                "city" => $location["city"],
                "street" => $location["street"],
                "house_number" => $location["house_number"],
                "user_id" => $userId,
            ]);
        } else {
            if (session()->exists("location")) {
                session()->remove("location");
            }
            session(["location" => $location]);
        }
    }
}
