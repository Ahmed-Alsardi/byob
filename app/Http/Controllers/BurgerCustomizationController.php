<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBurgerCustomizationRequest;
use App\Http\Requests\UpdateBurgerCustomizationRequest;
use App\Models\BurgerCustomization;
use App\Repository\BurgerCustomizationRepository;

class BurgerCustomizationController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(BurgerCustomization::class, "burgerCustomization");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cus = BurgerCustomizationRepository::getCustomizations();
        return view("customization.index", [
            "customizations" => $cus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBurgerCustomizationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BurgerCustomization $burgerCustomization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BurgerCustomization $burgerCustomization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBurgerCustomizationRequest $request, BurgerCustomization $burgerCustomization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BurgerCustomization $burgerCustomization)
    {
        //
    }
}
