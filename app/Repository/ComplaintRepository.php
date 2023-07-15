<?php

namespace App\Repository;

use App\Models\Admin;
use App\Models\Complaint;
use App\Models\Customer;
use App\Models\Order;
use App\Services\EmailNotificationService;
use Illuminate\Support\Facades\DB;

class ComplaintRepository
{

    const USER_ROLE_COMPLAINT = [
        UserRepository::ADMIN => Admin::class,
        UserRepository::CUSTOMER => Customer::class
    ];

    public static function createComplaint(Order $order, string $message)
    {
        $complaint = new Complaint();
        $complaint->order_id = $order->id;
        $complaint->customer_message = $message;
        $complaint->save();
        return $complaint;
    }

    public static function getComplaintsByUserId($userId, $userRole)
    {
        if (array_key_exists($userRole, self::USER_ROLE_COMPLAINT)){
            $userClass = self::USER_ROLE_COMPLAINT[$userRole];
            return $userClass::getComplaintsByUserID($userId);
        } else {
            return null;
        }
    }

    public static function resolveComplaint(Complaint $complaint, mixed $refund, mixed $admin_message, $adminId)
    {
        if ($complaint->is_resolved()) {
            return;
        }
        DB::transaction(function() use ($complaint, $refund, $admin_message, $adminId) {
            $complaint = $complaint->resolve($refund, $admin_message, $adminId);
            OrderRepository::resolveComplaintOrder($refund, $complaint->order_id);
        });
        EmailNotificationService::sendComplaintResolvedEmail($complaint);
    }
}
