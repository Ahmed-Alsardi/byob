<?php

namespace App\Repository;

use App\Models\Location;

class LocationRepository
{

    const LOCATION_SESSION_NAME = "location";

    public static function createLocation(array $location): void
    {
        $userId = auth()->id();
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

    public static function getUserLocation($user) {
        return Location::getLocationByCustomerId($user->id);
    }

    public static function getCustomerLocation($userId)
    {
        if ($userId) {
            return Location::getLocationByCustomerId($userId);
        } else {
            if (session()->exists(self::LOCATION_SESSION_NAME)) {
                return session()->get(self::LOCATION_SESSION_NAME);
            }
        }
        return null;
    }
}
