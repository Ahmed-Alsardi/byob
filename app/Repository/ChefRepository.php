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
}
