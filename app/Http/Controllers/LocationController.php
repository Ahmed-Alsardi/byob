<?php

namespace App\Http\Controllers;

use App\Features\Location\LocationViewsHandler;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use App\Repository\LocationRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, LocationViewsHandler $handler)
    {
        return $handler->handleCreate($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request, LocationViewsHandler $handler)
    {
        return $handler->handleStore($request);
    }
}
