<?php

namespace App\Policies;

use App\Helper\UserRole;
use App\Models\Complaint;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Auth\Access\Response;

class ComplaintPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewList(User $user): bool
    {
        return $this->isAdmin($user) || $this->isCustomer($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Complaint $complaint): bool
    {
        return $this->sameUserOrAdmin($user, $complaint);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->isCustomer($user);
    }

    public function store(User $user): bool
    {
        return $this->isCustomer($user);
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Complaint $complaint): bool
    {
        return $user->role === UserRepository::ADMIN;
    }

    /**
     * @param User $user
     * @param Complaint $complaint
     * @return bool
     */
    public function sameUserOrAdmin(User $user, Complaint $complaint): bool
    {
        if ($user->role === UserRepository::ADMIN || $user->id == $complaint->order->customer_id) {
            return true;
        }
        return false;
    }

    private function isAdmin(User $user)
    {
        return $user->role === UserRepository::ADMIN;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isCustomer(User $user): bool
    {
        return $user->role === UserRepository::CUSTOMER;
    }
}
