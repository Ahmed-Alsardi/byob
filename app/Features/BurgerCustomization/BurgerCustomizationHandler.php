<?php

namespace App\Features\BurgerCustomization;

use App\Models\BurgerCustomization;
use App\Repository\BurgerCustomizationRepository;
use Illuminate\Http\Request;

class BurgerCustomizationHandler
{

    public function handleList(Request $request)
    {
        $cus = BurgerCustomizationRepository::getAllCustomization();
        return view("customization.index", [
            "customizations" => $cus,
        ]);
    }

    public function handleCreate(Request $request)
    {
        return view("customization.create");
    }

    public function handleStore(Request $request)
    {
        BurgerCustomizationRepository::addCustomization($request->category, $request->name);
        return redirect()->route("customization.index");
    }

    public function handleView(Request $request, BurgerCustomization $burgerCustomization)
    {
        return view("customization.show", [
            "customization" => $burgerCustomization,
        ]);
    }

}
