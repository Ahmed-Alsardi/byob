<?php

use App\Http\Controllers\BurgerController;
use App\Http\Controllers\BurgerCustomizationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name("home");
Route::get("/burgers", [BurgerController::class, "index"])->name("burgers.index");
Route::post("/burgers", [BurgerController::class, "store"])->name("burgers.store");

Route::get("/location", [LocationController::class, "create"])->name("location.create");
Route::post("/location", [LocationController::class, "store"])->name("location.store");

Route::get("/checkout", [CheckoutController::class, "create"])->name("checkout.create");
Route::post("/checkout", [CheckoutController::class, "store"])->name("checkout.store");

Route::get("/checkout/success/{order}", [CheckoutController::class, "success"])->name("checkout.success");
Route::get("/checkout/cancel/{order}", [CheckoutController::class, "cancel"])->name("checkout.cancel");

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Order Routes
    Route::prefix('/orders')->group(function () {
        Route::get("/", [OrderController::class, "index"])->name("order.index");
        Route::get("/{order}", [OrderController::class, "show"])->name("order.show");
        Route::post("/{order}/complete", [OrderController::class, "complete"])->name("order.complete");
        Route::get("/{order}/complaint", [OrderController::class, "complaint"])->name("order.complaint");
        Route::post("/{order}/complaint", [OrderController::class, "storeComplaint"])->name("order.storeComplaint");
    });

    // Chef Routes
    Route::prefix("/chefs")->middleware("admin")->group(function () {
        Route::get("/chefs", [ChefController::class, "index"])->name("chef.index");
        Route::get("/chefs/create", [ChefController::class, "create"])->name("chef.create");
        Route::post("/chefs/create", [ChefController::class, "store"])->name("chef.store");
        Route::get("/chefs/{chef}", [ChefController::class, "show"])->name("chef.show");
        Route::delete("/chefs/{chef}", [ChefController::class, "destroy"])->name("chef.delete");
        Route::get("/chefs/{chef}/edit", [ChefController::class, "edit"])->name("chef.edit");
        Route::put("/chefs/{chef}/edit", [ChefController::class, "update"])->name("chef.update");
        Route::put("/chefs/{chef}/available", [ChefController::class, "changeAvailability"])->name("chef.available");
    });

    // Complaint Routes
    Route::prefix("/complaints")->group(function() {
        Route::get("/complaints", [ComplaintController::class, "index"])->name("complaint.index");
        Route::get("/complaints/{complaint}", [ComplaintController::class, "show"])->name("complaint.show");
        Route::put("/complaints/{complaint}", [ComplaintController::class, "update"])->name("complaint.update");
    });

    // Customization Routes
    Route::prefix('/customizations')->middleware("admin")->group(function () {
        Route::get("/", [BurgerCustomizationController::class, "index"])
            ->name("customization.index");
        Route::get("/create", [BurgerCustomizationController::class, "create"])
            ->name("customization.create");
        Route::post("/", [BurgerCustomizationController::class, "store"])
            ->name("customization.store");
        Route::get("/{burgerCustomization}", [BurgerCustomizationController::class, "show"])
            ->name("customization.show");
        Route::put("/{burgerCustomization}", [BurgerCustomizationController::class, "update"])
            ->name("customization.update");
    });
});


Route::middleware("auth")->group(function () {
});

require __DIR__.'/auth.php';
