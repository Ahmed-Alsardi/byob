<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBurgerRequest;
use App\Http\Requests\UpdateBurgerRequest;
use App\Models\Burger;
use App\Repository\BurgerCustomizationRepository;
use App\Repository\BurgerRepository;

class BurgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meats = BurgerCustomizationRepository::getMeats();
        $breads = BurgerCustomizationRepository::getBreads();
        $sides = BurgerCustomizationRepository::getSides();
        return view("burger", [
            "meats" => $meats,
            "breads" => $breads,
            "sides" => $sides,
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
    public function store(StoreBurgerRequest $request)
    {
        BurgerRepository::createBurger($request->all()["burgers"]);
        return redirect("/");
    }

    /**
     * Display the specified resource.
     */
    public function show(Burger $burger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Burger $burger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBurgerRequest $request, Burger $burger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Burger $burger)
    {
        //
    }
}
