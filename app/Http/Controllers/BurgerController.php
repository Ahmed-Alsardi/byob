<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBurgerRequest;
use App\Http\Requests\UpdateBurgerRequest;
use App\Models\Burger;
use App\Repository\BurgerCustomizationRepository;
use App\Repository\BurgerRepository;
use App\Repository\OrderRepository;
use Illuminate\Support\Facades\Cache;

class BurgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * TODO:
         * The below $meats, $breads, and $sides
         * We are doing 3 calls to the database which is unnecessary
         * We can decrease it to 1 DB call by getting them all in one query
         * and then utilize laravel collection to filter and display it as needed
         * ex:
         * $cuz = BurgerCustomizationRepository::getCustomizations() //getting all in one query
         * $meats = $cuz->where('type','meats')
         * $breads = $cuz->where('type','breads')
         * $sides = $cuz->where('type','sides')
         *
         * And to optimize this even further since we know that the sides and customization
         * will not be changed much, we should introduce a caching layer to prevent db calls
         * every time someone views the page, read about laravel caching
         * ==============================
         * DONE
         */


        /**
         * TODO:
         * use cache instead of sessions
         * make generic functions for update or create
         * always add null check conditions
         * use local scopes in model class when you are getting something from database
         * use flash laravel package for exceptions errors this is so help full when you are working on web
         * use parent controller for helper function or you can also make helper facades for this
         * rest all is good very nice
         * ==============================
         * 1. I don't think using cache will work here since the user can customize the burger without logging in
         * so I need to use session to store the data until the user logs in
         * 2. DONE (BaseRepository)
         */

        /**
         * TODO:
         * cache implementation is not correct
         * for first time it will not work use this
         * $cus = Cache::rememberForever('customizations', function () {
         * return BurgerCustomizationRepository::getCustomizations();
         * });
         * ==============================
         * Done
         */
        $cus = Cache::rememberForever(BurgerCustomizationRepository::CACHE_NAME, function () {
            return BurgerCustomizationRepository::getCustomizations();
        });
        $meats = $cus->where("category", "meat");
        $breads = $cus->where("category", "bread");
        $sides = $cus->where("category", "side");
        if (auth()->check()) {
            $order = OrderRepository::getUnpaidOrder(auth()->user())->first();
            /**
             * TODO:
             * use can simply use toArray() method here
             * like $order->burgers->toArray()
             * ==============================
             * convertFromEntityToArray it's to convert burger fields from id to name
             * for example this the fields in burger table
             * id: int, meat_id: int, bread_id: int, sides: json(contain ids of sides)
             * This function take the row and return:
             * meat: name (e.g chicken), bread: name (e.g white), sides: array of names (e.g [fries, coke])
             * The name of the function is actually misleading, it should be convertToReadableOrder or something like that
             */
            if ($order) {
                $burgers = $order->burgers;
                $burgers = $burgers->map(fn($burger) => BurgerRepository::convertToReadableOrder($burger));
            }
        } else {
            if (session()->exists("burgers")) {
                $burgers = session()->get("burgers");
            }
        }
        return view("burger", [
            "meats" => $meats,
            "breads" => $breads,
            "sides" => $sides,
            "burgers" => $burgers ?? [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBurgerRequest $request)
    {
        if (!$request->has("burgers")) {
            return redirect()->route("burgers.index");
        }
        if (auth()->check()) {
            /**
             * TODO:
             * I think you if he want to add another order so get his requested payment order and redirect him to orders page
             * if he want to edit so redirect to edit page
             * or if he want to create another order so delete his entire order and then make his new order
             * ==============================
             * The order of operation here is:
             * 1. User goes to /burger page, which this create and display last unpaid order
             * 2. User can add new, update, or delete burger in the page
             * 3. After he is done, and we delete all burger with the old order if it exists, and create a new one
             */
            $user = $request->user();
            $order = OrderRepository::getUnpaidOrCreate($user, true);
            BurgerRepository::createBurger($request->all()["burgers"], $order->id);
            if ($user->location_id) {
                return redirect()->route("checkout.create");
            }
        } else {
            BurgerRepository::createBurger($request->all()["burgers"]);
            if (session()->exists("location")) {
                return redirect()->route("checkout.create");
            }
        }
        return redirect()->route("location.create");
    }
}
