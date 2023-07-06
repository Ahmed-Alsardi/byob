<?php

namespace App\Http\Controllers;

use App\Helper\UserRole;
use App\Models\Chef;
use App\Services\ChefRepository;
use App\Services\ChefService;
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

    public function create(Request $request) {
        return view("chef.create");
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "name" => "required",
            "email" => "required|email",
        ]);
        ChefService::createChef($validated);
        return redirect()->route("chef.index");
    }
}
