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
        $this->authorize('view-list-chef');
        return $handler->handleList($request);
    }

    public function show(Request $request, Chef $chef, ChefViewsHandler $handler) {
        $this->authorize('view-chef');
        return $handler->handleShow($request, $chef);
    }

    public function create(Request $request, ChefViewsHandler $handler) {
        $this->authorize('create-chef');
        return $handler->handleCreate($request);
    }

    public function store(StoreChefRequest $request, ChefViewsHandler $handler) {
        $this->authorize('store-chef');
        return $handler->handleStore($request);
    }

    public function changeAvailability(UpdateChefAvailabilityRequest $request, ChefAvailableHandler $handler) {
        $this->authorize('update-available');
        return $handler->handle($request);
    }
    public function edit(Request $request, Chef $chef, ChefViewsHandler $handler) {
        $this->authorize('update-chef');
        return $handler->handleEdit($request, $chef);
    }
    public function destroy(Request $request, Chef $chef, ChefViewsHandler $handler) {
        $this->authorize('delete-chef');
        return $handler->handleDestroy($request, $chef);
    }

    public function update(UpdateChefRequest $request, Chef $chef, ChefViewsHandler $handler) {
        $this->authorize('update-chef');
        return $handler->handleUpdate($request, $chef);
    }
}
