<?php


use App\Http\Controllers\BurgerCustomizationController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get("/customizations", [BurgerCustomizationController::class, "index"])
        ->name("customization.index");
    Route::get("customizations/create", [BurgerCustomizationController::class, "create"])
        ->name("customization.create");
    Route::post("/customizations", [BurgerCustomizationController::class, "store"])
        ->name("customization.store");
    Route::get("/customizations/{burgerCustomization}", [BurgerCustomizationController::class, "show"])
        ->name("customization.show");
    Route::get("/customizations/{burgerCustomization}/edit", [BurgerCustomizationController::class, "edit"])
        ->name("customization.edit");
    Route::put("/customizations/{burgerCustomization}", [BurgerCustomizationController::class, "update"])
        ->name("customization.update");
});
