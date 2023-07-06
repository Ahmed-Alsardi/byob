<?php

namespace App\Helper;

class OrderStatus
{
    const REQUIRED_PAYMENT = "required_payment";
    const COMPLAINT = "complaint";
    const IN_PROGRESS = "in_progress";
    const COMPLETED = "completed";
    const REFUNDED = "refunded";
    const REFUND_REJECTED = "refund_rejected";
    const REFUND_FAILED = "refund_failed";

}
