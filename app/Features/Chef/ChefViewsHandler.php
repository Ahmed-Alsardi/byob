<?php

namespace App\Features\Chef;

use App\Http\Requests\StoreChefRequest;
use App\Http\Requests\UpdateChefRequest;
use App\Models\Chef;
use App\Repository\ChefRepository;
use Illuminate\Http\Request;

class ChefViewsHandler
{

    public function handleList(Request $request) {
        $allChefs = ChefRepository::getAllChefs();
        return view("chef.index", [
            "chefs" => $allChefs
        ]);
    }

    public function handleShow(Request $request, Chef $chef) {
        return view("chef.show", [
            "chef" => $chef
        ]);
    }

    public function handleCreate(Request $request) {
        return view("chef.create");
    }

    public function handleStore(StoreChefRequest $request)
    {
        $validated = $request->validated();
        ChefRepository::createChef($validated['name'], $validated['email']);
        return redirect()->route("chef.index");
    }

    public function handleEdit(Request $request, Chef $chef) {
        return view("chef.edit", [
            "chef" => $chef
        ]);
    }

    public function handleDestroy(Request $request, Chef $chef) {
        ChefRepository::deleteChef($chef->id);
        return redirect()->route("chef.index");
    }

    public function handleUpdate(UpdateChefRequest $request, Chef $chef)
    {
        $validated = $request->validated();
        ChefRepository::updateChef($chef, $validated['name'], $validated['email']);
        return redirect()->route("chef.index");
    }
}
