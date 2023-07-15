<?php

namespace App\Http\Controllers;

use App\Features\Chef\ChefAvailableHandler;
use App\Features\Chef\ChefViewsHandler;
use App\Http\Requests\StoreChefRequest;
use App\Http\Requests\UpdateChefAvailabilityRequest;
use App\Http\Requests\UpdateChefRequest;
use App\Models\Chef;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    public function index(Request $request, ChefViewsHandler $handler) {
        return $handler->handleList($request);
    }

    public function show(Request $request, Chef $chef, ChefViewsHandler $handler) {
        return $handler->handleShow($request, $chef);
    }

    public function create(Request $request, ChefViewsHandler $handler) {
        return $handler->handleCreate($request);
    }

    public function store(StoreChefRequest $request, ChefViewsHandler $handler) {
        return $handler->handleStore($request);
    }

    public function changeAvailability(UpdateChefAvailabilityRequest $request, ChefAvailableHandler $handler) {
        return $handler->handle($request);
    }
    public function edit(Request $request, Chef $chef, ChefViewsHandler $handler) {
        return $handler->handleEdit($request, $chef);
    }
    public function destroy(Request $request, Chef $chef, ChefViewsHandler $handler) {
        return $handler->handleDestroy($request, $chef);
    }

    public function update(UpdateChefRequest $request, Chef $chef, ChefViewsHandler $handler) {
        return $handler->handleUpdate($request, $chef);
    }
}
