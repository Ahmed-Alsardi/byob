<?php

namespace App\Features\Chef;

use App\Http\Requests\UpdateChefAvailabilityRequest;
use App\Services\ChefRepository;

class ChefAvailableHandler
{

    public function handle(UpdateChefAvailabilityRequest $request) {
        $validated = $request->validated();
        ChefRepository::updateAvailability($request->user(), $validated["unavailable_for"]);
        return redirect()->route("profile.edit");
    }

}
