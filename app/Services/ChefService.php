<?php

namespace App\Services;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ChefService
{

    public static function createChef(array $validated)
    {
        ChefRepository::createChef($validated['name'], $validated['email'], Str::random(8));
        $status = Password::sendResetLink(
            $validated
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($validated['email'])
                ->withErrors(['email' => __($status)]);
    }
}
