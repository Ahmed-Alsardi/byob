<?php

use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LocationController;
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
});

require __DIR__.'/auth.php';
require __DIR__.'/order.php';
require __DIR__.'/chef.php';
require __DIR__.'/complaint.php';
require __DIR__.'/customization.php';
