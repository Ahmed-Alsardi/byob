<?php


use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function() {
    Route::get("/complaints", [ComplaintController::class, "index"])->name("complaint.index");
    Route::get("/complaints/{complaint}", [ComplaintController::class, "show"])->name("complaint.show");
    Route::put("/complaints/{complaint}", [ComplaintController::class, "update"])->name("complaint.update");
});
