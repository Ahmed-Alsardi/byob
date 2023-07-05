<?php

namespace App\Repository;

use App\Models\Complaint;
use App\Models\Order;

class ComplaintRepository
{

    public static function getOrderComplaint($orderId)
    {
        return Complaint::where("order_id", $orderId)->first();
    }

    public static function createComplaint(Order $order, string $message)
    {
        $complaint = new Complaint();
        $complaint->order_id = $order->id;
        $complaint->customer_message = $message;
        $complaint->save();
        return $complaint;
    }
}
