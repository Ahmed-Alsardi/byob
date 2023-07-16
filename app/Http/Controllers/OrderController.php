<?php

namespace App\Http\Controllers;

use App\Features\Order\OrderViewsHandler;
use App\Http\Requests\StoreComplaintRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, OrderViewsHandler $handler)
    {
        $this->authorize('view-list-order');
        return $handler->handleList($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Order $order, OrderViewsHandler $handler)
    {
        $this->authorize('view-order', $order);
        return $handler->handleShow($request, $order);
    }

    public function complete(Request $request, Order $order, OrderViewsHandler $handler) {
        $this->authorize('complete-order', $order);
        return $handler->handleComplete($request, $order);
    }

    public function complaintCreate(Request $request, Order $order, OrderViewsHandler $handler) {
        $this->authorize('create-complaint', $order);
        return $handler->handleComplaintCreate($request, $order);
    }

    public function storeComplaint(StoreComplaintRequest $request, Order $order, OrderViewsHandler $handler) {
        $this->authorize('store-complaint', $order);
        return $handler->handleStoreComplaint($request, $order);
    }
}
