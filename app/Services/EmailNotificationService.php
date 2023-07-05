<?php

namespace App\Services;

use App\Mail\OrderComplete;
use App\Mail\OrderReceipt;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class EmailNotificationService
{

    public static function sendReceiptEmail(Order $order): void
    {
        $customerEmail = $order->customer->email;
        Mail::to($customerEmail)->send(new OrderReceipt($order));
    }

    public static function sendOrderCompletedEmail(Order $order)
    {
        $customerEmail = $order->customer->email;
        Mail::to($customerEmail)->send(new OrderComplete($order));
    }

}
