<?php

namespace App\Services;

use App\Models\Chef;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ChefService
{

    public static function createChef(array $validated)
    {
        ChefRepository::createChef($validated['name'], $validated['email'], Str::random(8));
        return self::sendChangePasswordEmail($validated);
    }

    public static function updateChef(Chef $chef, array $validated)
    {
        $chefEmail = $chef->email;
        $chef->update([
            "name" => $validated["name"] ?? $chef->name,
            "email" => $validated["email"] ?? $chef->email,
        ]);
        if (isset($validated["email"]) && $chefEmail !== $validated["email"]) {
            return self::sendChangePasswordEmail($validated);
        }
    }

    /**
     * @param array $validated
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function sendChangePasswordEmail(array $validated): \Illuminate\Http\RedirectResponse
    {
        $status = Password::sendResetLink(
            $validated
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($validated['email'])
                ->withErrors(['email' => __($status)]);
    }
}
