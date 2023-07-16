<?php

namespace App\Features\Burgers;

use App\Repository\OrderRepository;

class BurgerStore
{
    public function handle($request) {
        if (!$request->has("burgers")) {
            return redirect()->route("burgers.index");
        }
        $userId = $request->user()?->id;
        OrderRepository::saveCustomerBurgers($request->all()["burgers"], $userId);
        return redirect()->route("location.create");
    }
}
