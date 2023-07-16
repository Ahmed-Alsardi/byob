<?php

namespace App\Features\Location;

use App\Http\Requests\StoreLocationRequest;
use App\Repository\LocationRepository;
use Illuminate\Http\Request;

class LocationViewsHandler
{

    public function handleCreate(Request $request) {
        $userId = $request->user()?->id;
        $location = LocationRepository::getCustomerLocation($userId);
        return view("location", [
            "location" => $location,
        ]);
    }

    public function handleStore(StoreLocationRequest $request)
    {
        $validated = $request->validated();
        $userId = $request->user()?->id;
        LocationRepository::createLocation($userId, $validated);
        return redirect()->route("checkout.create");
    }
}
