<?php

namespace App\Http\Controllers;

use App\Features\Burgers\BurgerStore;
use App\Features\Burgers\BurgerView;
use App\Http\Requests\StoreBurgerRequest;
use App\Repository\BurgerRepository;
use App\Repository\OrderRepository;
use Illuminate\Http\Request;

class BurgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BurgerView $burgerView)
    {
        return $burgerView->handle($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBurgerRequest $request, BurgerStore $burgerStore)
    {
        return $burgerStore->handle($request);
    }
}
