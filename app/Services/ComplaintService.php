<?php

namespace App\Services;

use App\Helper\OrderStatus;
use App\Models\Complaint;
use Illuminate\Support\Facades\DB;

class ComplaintService
{

    public static function resolveComplaint(Complaint $complaint, bool $refund, string $admin_message, $admin)
    {
        if ($complaint->is_resolved()) {
            return;
        }
        DB::transaction(function() use ($complaint, $refund, $admin_message, $admin) {
            $complaint->refund = $refund;
            $complaint->admin_message = $admin_message;
            $complaint->admin_id = $admin->id;
            $complaint->save();
            if ($refund) {
                $result = $complaint->order->refund();
                if ($result['status'] == 'succeeded') {
                    $complaint->order->status = OrderStatus::REFUNDED;
                    $complaint->order->save();
                } else {
                    $complaint->order->status = OrderStatus::REFUND_FAILED;
                    $complaint->order->save();
                    throw new \Exception("Refund failed");
                }
            } else {
                $complaint->order->status = OrderStatus::REFUND_REJECTED;
                $complaint->order->save();
            }
        });
        EmailNotificationService::sendComplaintResolvedEmail($complaint);
    }
}
