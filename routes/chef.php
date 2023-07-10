<?php

use App\Http\Controllers\ChefController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function() {
    Route::get("/chefs", [ChefController::class, "index"])->name("chef.index");
    Route::get("/chefs/create", [ChefController::class, "create"])->name("chef.create");
    Route::post("/chefs/create", [ChefController::class, "store"])->name("chef.store");
    Route::get("/chefs/{chef}", [ChefController::class, "show"])->name("chef.show");
    Route::delete("/chefs/{chef}", [ChefController::class, "destroy"])->name("chef.delete");
    Route::get("/chefs/{chef}/edit", [ChefController::class, "edit"])->name("chef.edit");
    Route::put("/chefs/{chef}/edit", [ChefController::class, "update"])->name("chef.update");
    Route::put("/chefs/{chef}/available", [ChefController::class, "changeAvailability"])->name("chef.available");
});
