<?php

namespace App\Http\Controllers;

use App\Helper\UserRole;
use App\Models\Chef;
use App\Services\ChefRepository;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    public function index() {
        if (auth()->user()->role !== UserRole::ADMIN) {
            abort(403);
        }
        return view("chef.index", [
            "chefs" => ChefRepository::getAllChefs()
        ]);
    }

    public function show(Chef $chef) {

    }

    public function create() {

    }
}
