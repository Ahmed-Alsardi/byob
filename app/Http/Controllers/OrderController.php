<?php

namespace App\Http\Controllers;

use App\Helper\OrderStatus;
use App\Helper\UserRole;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Repository\OrderRepository;
use App\Services\EmailNotificationService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = OrderRepository::getOrdersByUser();
        if ($request->get("api", false)){
            return response()->json([
                "orders" => $orders
            ]);
        }
        return view("orders", [
            "orders" => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $user = auth()->user();
        if ($order->customer_id != $user->id && $order->chef_id != $user->id && $user->role !== UserRole::ADMIN) {
            return redirect()->route("order.index");
        }
        if ($order->status === OrderStatus::REQUIRED_PAYMENT) {
            return redirect()->route("checkout.create");
        }
        $order->total_price = $order->total_price ?? OrderService::calculatePrice($order);
        return view("order", [
            "order" => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    public function complete(Order $order) {
       if (auth()->user()->id !== $order->chef_id) {
           return redirect()->route("order.index");
       }
       if (OrderService::completeOrder(auth()->user(), $order)){
           EmailNotificationService::sendOrderCompletedEmail($order);
       } else {
           /**
            * TODO
            * return 422 error not eception this is not exception
            */
           abort(500);
       }
       return redirect()->route("order.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function complaint(Order $order) {
        if (auth()->user()->id !== $order->customer_id) {
            return redirect()->route("order.index");
        }
        return view("complaint-create", [
            "order" => $order
        ]);
    }

    public function storeComplaint(Request $request, Order $order) {
        if (auth()->user()->id !== $order->customer_id) {
            return redirect()->route("order.index");
        }
        if ($order->complaint != null) {
            return redirect()->route("order.index");
//            return redirect()->route("complaint.show", $order->complaint->id);
        }
        $validated = $request->validate([
            "message" => "required|string|max:255"
        ]);
        $complaint = OrderService::complaintOrder($order, $validated["message"]);
        return redirect()->route("complaint.show", $complaint);
    }
}
