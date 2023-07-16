<?php

namespace App\Policies;

use App\Helper\UserRole;
use App\Models\Order;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    public function viewList(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        return $this->sameChefOrCustomer($user, $order) || $this->isAdmin($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function createComplaint(User $user, Order $order): bool
    {
        return $this->checkUserComplaint($user, $order);
    }

    public function storeComplaint(User $user, Order $order): bool {
        return $this->checkUserComplaint($user, $order);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function completeOrder(User $user, Order $order): bool
    {
        return $this->isOrderAssignToChef($user, $order);
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function sameChefOrCustomer(User $user, Order $order): bool
    {
        if ($user->id === $order->customer_id ||
            $this->isOrderAssignToChef($user, $order)
        ) {
            return true;
        }
        return false;
    }

    private function isAdmin(User $user)
    {
        return $user->role === UserRepository::ADMIN;
    }

    private function isOrderAssignToChef(User $user, Order $order)
    {
        if ($user->id === $order->chef_id) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function checkUserComplaint(User $user, Order $order): bool
    {
        return $user->role === UserRepository::CUSTOMER && $order->customer_id === $user->id;
    }
}
