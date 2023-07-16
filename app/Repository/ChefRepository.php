<?php

namespace App\Repository;

use App\Models\Chef;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ChefRepository
{


    public static function getAllChefs(): Collection
    {
        return Chef::all();
    }

    public static function getAllAvailableChef(): Collection
    {
        return Chef::getAllAvailableChefs();
    }

    public static function createChef($name, $email)
    {
        Chef::createChef($name, $email, Str::random(8));
        return self::sendChangePasswordEmail($email);
    }

    public static function updateAvailability($userId, mixed $unavailable_for)
    {
        Chef::updateChefAvailability($userId, $unavailable_for);
    }

    public static function deleteChef(mixed $chefId)
    {
        return Chef::deleteChefWithId($chefId);
    }

    public static function updateChef(Chef $chef, $name, $email)
    {
        $oldEmail = $chef->email;
        $chef->updateInformation($name, $email);
        if ($email !== $oldEmail) {
            self::sendChangePasswordEmail($email);
        }
    }

    private static function sendChangePasswordEmail($email)
    {
        $status = Password::sendResetLink(
            [$email]
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($email)
                ->withErrors(['email' => __($status)]);
    }

    public static function getChefToAssignOrder(): Chef {
        $chefs = self::getAllAvailableChef();
        if ($chefs->count() == 0) {
            throw new \Exception("No chefs available");
        }
        if ($chefs->count() == 1) {
            return $chefs->first();
        }
        // get the chef of the last order
        $lastOrder = OrderRepository::getLastOrder();
        if ($lastOrder == null) {
            $chef = $chefs->first();
            if ($chef == null) {
                throw new \Exception("No chefs available");
            }
            return $chef;
        }
        $chef = $chefs
            ->where("id", ">", $lastOrder->chef_id)
            ->sortBy("id")
            ->first();
        // sort the chefs based on the unavailability time
        if ($chef == null) {
            $chef = $chefs->first();
            if ($chef == null) {
                throw new \Exception("No chefs available");
            }
        }
        return $chef;
    }
}
