<?php

namespace App\Http\Controllers;

use App\Features\BurgerCustomization\BurgerCustomizationHandler;
use App\Http\Requests\StoreBurgerCustomizationRequest;
use App\Models\BurgerCustomization;
use Illuminate\Http\Request;

class BurgerCustomizationController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BurgerCustomizationHandler $handler)
    {
        return $handler->handleList($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, BurgerCustomizationHandler $handler)
    {
        return $handler->handleCreate($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBurgerCustomizationRequest $request, BurgerCustomizationHandler $handler)
    {
        return $handler->handleStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, BurgerCustomization $burgerCustomization, BurgerCustomizationHandler $handler)
    {
       return $handler->handleView($request, $burgerCustomization);
    }
}
