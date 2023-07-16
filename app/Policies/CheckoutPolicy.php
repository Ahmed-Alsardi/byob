<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Auth\Access\Response;

class CheckoutPolicy
{
    private static function isUserCustomer(User $user)
    {
        return $user->role == UserRepository::CUSTOMER;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function create(?User $user) {
        if (!$user) {
            return Response::allow();
        }
        if (self::isUserCustomer($user)) {
            return Response::allow();
        }
        return Response::deny('You are not allowed to perform this action as you are not a customer');
    }

    public function store(User $user) {
        if (self::isUserCustomer($user)) {
            return Response::allow();
        }
        return Response::deny('You are not allowed to perform this action as you are not a customer');
    }

    public function success(User $user, Order $order) {
        if (self::isUserCustomer($user)) {
            return Response::allow();
        }
        if ($this->ownerOfOrder($user, $order)) {
            return Response::allow();
        }
        return Response::deny('You are not allowed to perform this action as you are not a customer or you are not the owner of this order');
    }

    public function cancel(User $user, Order $order) {
        if (self::isUserCustomer($user)) {
            return Response::allow();
        }
        if ($this->ownerOfOrder($user, $order)) {
            return Response::allow();
        }
        return Response::deny('You are not allowed to perform this action as you are not a customer or you are not the owner of this order');
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function ownerOfOrder(User $user, Order $order): bool
    {
        return $user->id == $order->customer_id;
    }

}
