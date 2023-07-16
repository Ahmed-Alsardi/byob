<?php

namespace App\Repository;

use App\Models\Location;

class LocationRepository
{

    const LOCATION_SESSION_NAME = "location";

    public static function createLocation($userId, array $location): void
    {
        if ($userId) {
            Location::createCustomerLocation($userId, $location);
        } else {
            if (session()->exists("location")) {
                session()->remove("location");
            }
            session([self::LOCATION_SESSION_NAME => $location]);
        }
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
