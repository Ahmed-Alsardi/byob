<?php

namespace App\Http\Controllers;

use App\Features\Location\LocationViewsHandler;
use App\Http\Requests\StoreLocationRequest;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, LocationViewsHandler $handler)
    {
        $this->authorize('create-location');
        return $handler->handleCreate($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request, LocationViewsHandler $handler)
    {
        $this->authorize('store-location');
        return $handler->handleStore($request);
    }
}
