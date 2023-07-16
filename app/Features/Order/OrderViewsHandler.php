<?php

namespace App\Features\Order;

use App\Http\Requests\StoreComplaintRequest;
use App\Models\Order;
use App\Repository\ComplaintRepository;
use App\Repository\OrderRepository;
use App\Services\EmailNotificationService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderViewsHandler
{

    public function handleList(Request $request) {
        $user = $request->user();
        $orders = OrderRepository::getOrdersByUser($user);
        return view("orders", [
            "orders" => $orders,
        ]);
    }

    public function handleShow(Request $request, Order $order) {
        if ($order->status === OrderRepository::REQUIRED_PAYMENT) {
            return redirect()->route("checkout.create");
        }
        return view("order", [
            "order" => $order
        ]);
    }

    public function handleComplete(Request $request, Order $order)
    {
        $userId = $request->user()->id;
        $result = OrderRepository::completeOrder($userId, $order);
        if ($result){
            EmailNotificationService::sendOrderCompletedEmail($order);
        } else {
            abort(500);
        }
        return redirect()->route("order.index");
    }

    public function handleComplaintCreate(Request $request, Order $order)
    {
        return view("complaint-create", [
            "order" => $order
        ]);
    }

    public function handleStoreComplaint(StoreComplaintRequest $request, Order $order)
    {
        if (OrderRepository::orderHasComplaint($order)) {
            return redirect()->route("order.index");
        }
        $validated = $request->validated();
        $complaint = ComplaintRepository::createComplaint($order, $validated["message"]);
        return redirect()->route("complaint.show", $complaint);
    }
}
