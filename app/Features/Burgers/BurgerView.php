<?php

namespace App\Features\Burgers;

use App\Repository\BurgerCustomizationRepository;
use App\Repository\OrderRepository;
use Illuminate\Http\Request;

class BurgerView
{

    public function handle(Request $request)
    {
        $cus = BurgerCustomizationRepository::getAllCustomization();
        $meats = $cus->where("category", "meat");
        $breads = $cus->where("category", "bread");
        $sides = $cus->where("category", "side");
        $userId = $request->user()?->id;
        $burgers = OrderRepository::getCustomerBurgers($userId);
        return view("burger", [
            "meats" => $meats,
            "breads" => $breads,
            "sides" => $sides,
            "burgers" => $burgers ?? [],
        ]);
    }

}
