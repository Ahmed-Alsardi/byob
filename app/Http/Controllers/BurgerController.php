<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBurgerRequest;
use App\Http\Requests\UpdateBurgerRequest;
use App\Models\Burger;
use App\Repository\BurgerCustomizationRepository;

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
        if (session()->exists("burgers")) {
            session()->remove("burgers");
        }
        session(["burgers" => $request->all()['burgers']]);
        dump(session()->get("burgers"));
        return redirect("/burgers");
        $burgers = [];
//        foreach ($request->all()['burgers'] as $b) {
//            $meat_id = BurgerCustomizationRepository::getId("meat", $b['meat']);
//            $bread_id = BurgerCustomizationRepository::getId("bread", $b['bread']);
//            $sides = [];
//            if (isset($b["sides"])) {
//                foreach ($b['sides'] as $side) {
//                    $sides[] = BurgerCustomizationRepository::getId("side", $side);
//                }
//            }
//            $burgers[] = [
//                "meat_id" => $meat_id,
//                "bread_id" => $bread_id,
//                "sides" => $sides,
//            ];
//        }
//        // if the user is logged in, create new order with the user id
//        if (auth()->check()) {
//            // create the order here
//        }
//        $burgers = Burger::query()->insert($burgers);
//        $request->session()->put("burgers", $burgers);
//        return redirect()->route("checkout");
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
