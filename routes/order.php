<?php


use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get("/orders", [OrderController::class, "index"])->name("order.index");
    Route::get("/orders/{order}", [OrderController::class, "show"])->name("order.show");
    Route::post("/orders/{order}/complete", [OrderController::class, "complete"])->name("order.complete");
    Route::get("/orders/{order}/complaint", [OrderController::class, "complaint"])->name("order.complaint");
    Route::post("/orders/{order}/complaint", [OrderController::class, "storeComplaint"])->name("order.storeComplaint");
});
